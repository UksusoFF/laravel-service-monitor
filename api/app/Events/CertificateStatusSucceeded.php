<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Monitor;
use App\Models\MonitorCertificateStatus;
use Spatie\SslCertificate\SslCertificate;

class CertificateStatusSucceeded extends AbstractEvent implements HasMessage
{
    public function __construct(
        public Monitor $monitor,
        public MonitorCertificateStatus $status,
        public SslCertificate $certificate,
    ) {

    }

    public function getMessageText(): string
    {
        return "✅ Статус SSL изменился на {$this->monitor->certificate_status}".PHP_EOL."{$this->monitor->url}";
    }
}
