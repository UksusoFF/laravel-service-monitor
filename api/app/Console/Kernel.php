<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\VersionIncrementCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        VersionIncrementCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        //
    }

    protected function bootstrappers(): array
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}
