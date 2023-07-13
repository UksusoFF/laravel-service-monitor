<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Events\CertificateStatusFailed;
use App\Events\CertificateStatusSucceeded;
use App\Models\MonitorCertificateStatus;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\SslCertificate\SslCertificate;
use Spatie\UptimeMonitor\Models\Enums\CertificateStatus;

trait SupportsCertificateCheck
{
    public function certificate(): HasOne
    {
        return $this->hasOne(MonitorCertificateStatus::class)->latest();
    }

    public function certificatePrevious(): HasOne
    {
        return $this->certificate()->skip(1);
    }

    public function getCertificateStatusAttribute(): string
    {
        return $this->certificate?->certificate_status ?? CertificateStatus::NOT_YET_CHECKED;
    }

    public function setCertificateCheckFailureReasonAttribute(string $reason): void
    {
        /** @var \App\Models\MonitorCertificateStatus $status */
        $status = $this->certificate()->get();

        $status->certificate_status = $reason;

        $status->save();
    }

    public function setCertificate(SslCertificate $certificate): void
    {
        $isStatusChanged = ($this->certificate?->certificate_status ?? null) !== CertificateStatus::VALID;

        $newStatus = $certificate->isValid($this->raw_url)
            ? CertificateStatus::VALID
            : CertificateStatus::INVALID;

        $status = new MonitorCertificateStatus();

        $status->monitor_id = $this->id;
        $status->certificate_status = $newStatus;
        $status->certificate_expiration_date = $certificate->expirationDate();
        $status->certificate_issuer = $certificate->getIssuer();

        $status->save();

        if ($isStatusChanged) {
            event(new CertificateStatusSucceeded($this, $status, $certificate));
        }
    }

    public function setCertificateException(Exception $exception): void
    {
        $isStatusChanged = ($this->certificate?->certificate_status ?? null) !== CertificateStatus::INVALID;

        $status = new MonitorCertificateStatus();

        $status->monitor_id = $this->id;
        $status->certificate_status = CertificateStatus::INVALID;
        $status->certificate_expiration_date = null;
        $status->certificate_issuer = '';
        $status->certificate_check_failure_reason = $exception->getMessage();

        $this->save();

        if ($isStatusChanged) {
            event(new CertificateStatusFailed($this, $status));
        }
    }
}
