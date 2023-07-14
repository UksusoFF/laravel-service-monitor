<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Checks\CheckStatus;
use App\Checks\MegafonCheck;
use App\Models\Monitor;

class MonitorDailyReportCommand extends AbstractMonitorCommand
{
    protected $signature = 'monitor:daily-report';

    protected $description = 'Command send daily report';

    protected function process(): void
    {
        $check = app(MegafonCheck::class);
        $check->check();
        if ($check->status !== CheckStatus::SUCCESS) {
            $this->errors[] = $check->getMessageText();
        }

        Monitor::failedUptimeCheck()
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url}: {$monitor->uptime_status}";
            });

        Monitor::failedCertificateCheck()
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url}: {$monitor->certificate_status}";
            });
    }
}
