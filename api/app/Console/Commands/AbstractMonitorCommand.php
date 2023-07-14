<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\Commands\Traits\ErrorReportable;
use Illuminate\Console\Command;

abstract class AbstractMonitorCommand extends Command
{
    use ErrorReportable;

    public function handle(): int
    {
        $this->check();

        $this->process();

        $this->errorReport();

        return Command::SUCCESS;
    }

    protected function check(): void
    {
        //
    }

    protected function process(): void
    {
        //
    }
}
