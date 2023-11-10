<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Checks\CheckRepository;

class MonitorCheckCheckCommand extends AbstractMonitorCommand
{
    protected $signature = 'monitor:check-check';

    protected $description = 'Command checks check';

    public function __construct(
        protected CheckRepository $checks
    ) {
        parent::__construct();
    }

    protected function check(): void
    {
        foreach ($this->checks->all() as $check) {
            $check->check();

            if ($check->shouldBeReported()) {
                $this->messages[] = $check->getMessageText();
            }
        }
    }
}
