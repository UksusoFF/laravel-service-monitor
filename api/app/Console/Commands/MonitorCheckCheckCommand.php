<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Checks\CheckStatus;
use App\Checks\MegafonCheck;

class MonitorCheckCheckCommand extends AbstractMonitorCommand
{
    protected $signature = 'monitor:check-check';

    protected $description = 'Command checks check';

    protected function check(): void
    {
        $check = app(MegafonCheck::class);
        $check->check();
        if ($check->status !== CheckStatus::SUCCESS) {
            $this->errors[] = $check->getMessageText();
        }
    }

    protected function process(): void
    {
        return;
    }
}
