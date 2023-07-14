<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Monitor;

class MonitorCheckUptimeCommand extends AbstractMonitorCommand
{
    protected $signature = 'monitor:check-uptime';

    protected $description = 'Command checks uptime';

    protected function check(): void
    {
        Monitor::query()
            ->get()
            ->each(function(Monitor $monitor) {
                $monitor->checkUptime();
            });
    }

    protected function process(): void
    {
        Monitor::failedUptimeCheck()
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url}: {$monitor->uptime_status}";
            });
    }
}
