<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Checks\CheckRepository;
use App\Models\Monitor;

class MonitorDailyStatusReportCommand extends AbstractMonitorCommand
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
        $this->errors[] = 'Статус системы сегодня';

        foreach ($this->checks->all() as $check) {
            $check->check();
            $this->errors[] = $check->getMessageText();
        }

        Monitor::query()
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url}: {$monitor->uptime_status}";
            });

        Monitor::query()
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url}: {$monitor->certificate_status}";
            });
    }
}
