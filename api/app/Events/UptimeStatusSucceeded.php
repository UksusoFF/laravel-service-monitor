<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Monitor;
use App\Models\MonitorUptimeStatus;

class UptimeStatusSucceeded extends AbstractEvent implements HasMessage
{
    public function __construct(
        public Monitor $monitor,
        public MonitorUptimeStatus $status,
    ) {

    }

    public function getMessageText(): string
    {
        return "✅ Статус сайта изменился на {$this->status->uptime_status}".PHP_EOL."{$this->monitor->url}";
    }
}
