<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Monitor;

class MonitorCheckCertificateCommand extends AbstractMonitorCommand
{
    protected $signature = 'monitor:check-certificate';

    protected $description = 'Command checks certificate';

    protected function check(): void
    {
        Monitor::query()
            ->get()
            ->each(function(Monitor $monitor) {
                $monitor->checkCertificate();
            });
    }

    protected function process(): void
    {
        Monitor::failedCertificateCheck()
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url}: {$monitor->certificate_status}";
            });
    }
}
