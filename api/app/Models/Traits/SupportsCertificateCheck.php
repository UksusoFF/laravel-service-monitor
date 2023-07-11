<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\MonitorCertificateStatus;
use Exception;
use Spatie\SslCertificate\SslCertificate;
use Spatie\UptimeMonitor\Events\CertificateCheckFailed;
use Spatie\UptimeMonitor\Models\Enums\CertificateStatus;

trait SupportsCertificateCheck
{
    public function getCertificateStatusAttribute(): string
    {
        return $this->certificateStatuses->first()?->certificate_status ?? CertificateStatus::INVALID;
    }

    public function setCertificateCheckFailureReasonAttribute(string $reason): void
    {
        $status = $this->certificateStatuses->first();

        $status->certificate_status = $reason;

        $status->save();
    }

    public function setCertificate(SslCertificate $certificate): void
    {
        $status = new MonitorCertificateStatus();

        $status->monitor_id = $this->id;
        $status->certificate_status = $certificate->isValid($this->raw_url)
            ? CertificateStatus::VALID
            : CertificateStatus::INVALID;
        $status->certificate_expiration_date = $certificate->expirationDate();
        $status->certificate_issuer = $certificate->getIssuer();

        $status->save();

        $this->fireEventsForUpdatedMonitorWithCertificate($this, $certificate);
    }

    public function setCertificateException(Exception $exception): void
    {
        $status = new MonitorCertificateStatus();

        $status->monitor_id = $this->id;
        $status->certificate_status = CertificateStatus::INVALID;
        $status->certificate_expiration_date = null;
        $status->certificate_issuer = '';
        $status->certificate_check_failure_reason = $exception->getMessage();

        $this->save();

        event(new CertificateCheckFailed($this, $exception->getMessage()));
    }
}
