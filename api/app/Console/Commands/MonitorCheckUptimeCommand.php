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
}
