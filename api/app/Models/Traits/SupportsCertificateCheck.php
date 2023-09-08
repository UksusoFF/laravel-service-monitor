<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Events\CertificateStatusFailed;
use App\Events\CertificateStatusSucceeded;
use App\Models\Enums\CertificateStatus;
use App\Models\MonitorCertificateStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\SslCertificate\SslCertificate;

trait SupportsCertificateCheck
{
    public function scopeFailedCertificateCheck(Builder $query): void
    {
        $query
            ->whereDoesntHave('certificate')
            ->orWhereHas('certificate', function(Builder $query) {
                $query->whereNot('certificate_status', CertificateStatus::VALID);
            });
    }

    public function checkCertificate(): void
    {
        try {
            $certificate = SslCertificate::createForHostName($this->url);

            $this->setCertificate($certificate);
        } catch (Exception $exception) {
            $this->setCertificateException($exception);
        }
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(MonitorCertificateStatus::class)->latestOfMany();
    }

    public function certificatePrevious(): HasOne
    {
        return $this->certificate()->skip(1);
    }

    public function setCertificate(SslCertificate $certificate): void
    {
        $isStatusChanged = $this->certificate->certificate_status !== CertificateStatus::VALID;

        $newStatus = $this->getCertificateStatus($certificate);

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
        $isStatusChanged = $this->certificate->certificate_status !== CertificateStatus::INVALID;

        $status = new MonitorCertificateStatus();

        $status->monitor_id = $this->id;
        $status->certificate_status = CertificateStatus::INVALID;
        $status->certificate_expiration_date = null;
        $status->certificate_issuer = '';
        $status->certificate_check_failure_reason = $exception->getMessage();

        $status->save();

        if ($isStatusChanged) {
            event(new CertificateStatusFailed($this, $status));
        }
    }

    protected function getCertificateStatus(SslCertificate $certificate): CertificateStatus
    {
        if (!$certificate->isValid()) {
            return CertificateStatus::INVALID;
        }

        if ($certificate->expirationDate()->isBefore(Carbon::now()->addMonth())) {
            return CertificateStatus::EXPIRING;
        }

        return CertificateStatus::VALID;
    }
}
