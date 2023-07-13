<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Monitor;
use App\Models\MonitorCertificateStatus;

class CertificateStatusFailed extends AbstractEvent implements HasMessage
{
    public function __construct(
        public Monitor $monitor,
        public MonitorCertificateStatus $status,
    ) {

    }

    public function getMessageText(): string
    {
        return "⚠️ Статус SSL изменился на {$this->status->certificate_status}".PHP_EOL."{$this->monitor->raw_url}";
    }
}
