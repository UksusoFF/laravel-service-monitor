<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\MonitorDailyNotify;
use App\Console\Commands\MonitorImport;
use App\Console\Commands\VersionIncrementCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\UptimeMonitor\Commands\CheckCertificates;
use Spatie\UptimeMonitor\Commands\CheckUptime;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        VersionIncrementCommand::class,
        MonitorDailyNotify::class,
        MonitorImport::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(CheckUptime::class)->everyMinute();
        $schedule->command(CheckCertificates::class)->daily();
    }

    protected function bootstrappers(): array
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}
