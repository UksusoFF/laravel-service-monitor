<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\MonitorCheckCertificateCommand;
use App\Console\Commands\MonitorCheckCheckCommand;
use App\Console\Commands\MonitorCheckUptimeCommand;
use App\Console\Commands\MonitorDailyReportCommand;
use App\Console\Commands\MonitorImport;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        MonitorCheckCertificateCommand::class,
        MonitorCheckCheckCommand::class,
        MonitorCheckUptimeCommand::class,
        MonitorDailyReportCommand::class,
        MonitorImport::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(MonitorCheckCertificateCommand::class)->daily();
        $schedule->command(MonitorCheckUptimeCommand::class)->everyMinute();
        $schedule->command(MonitorCheckCheckCommand::class)->everyOddHour();
        $schedule->command(MonitorDailyReportCommand::class)->dailyAt('9:00');
    }

    protected function bootstrappers(): array
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}
