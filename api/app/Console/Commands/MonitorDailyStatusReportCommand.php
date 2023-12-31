<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Checks\CheckRepository;
use App\Models\Monitor;

class MonitorDailyStatusReportCommand extends AbstractMonitorCommand
{
    protected $signature = 'monitor:daily-status-report';

    protected $description = 'Command send daily status report';

    public function __construct(
        protected CheckRepository $checks
    ) {
        parent::__construct();
    }

    protected function process(): void
    {
        $this->messages[] = 'Статус системы сегодня';

        foreach ($this->checks->all() as $check) {
            $check->check();
            $this->messages[] = $check->getMessageText();
        }

        Monitor::query()
            ->get()
            ->each(function(Monitor $monitor) {
                $this->messages[] = "{$monitor->uptime->getMessageText()}";
            });

        Monitor::query()
            ->get()
            ->each(function(Monitor $monitor) {
                $this->messages[] = "{$monitor->certificate->getMessageText()}";
            });
    }
}
