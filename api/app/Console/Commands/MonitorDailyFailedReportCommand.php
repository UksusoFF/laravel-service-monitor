<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Checks\CheckRepository;
use App\Models\Monitor;

class MonitorDailyFailedReportCommand extends AbstractMonitorCommand
{
    protected $signature = 'monitor:daily-failed-report';

    protected $description = 'Command send daily failed report';

    public function __construct(
        protected CheckRepository $checks
    ) {
        parent::__construct();
    }

    protected function process(): void
    {
        foreach ($this->checks->all() as $check) {
            $check->check();

            if ($check->shouldBeReported()) {
                $this->errors[] = $check->getMessageText();
            }
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
