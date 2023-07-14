<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Enums\UptimeStatus;
use App\Models\Monitor;
use Illuminate\Database\Eloquent\Builder;

class MonitorCheckUptimeCommand extends AbstractMonitorCommand
{
    protected $signature = 'monitor:check-uptime';

    protected $description = 'Command checks uptime';

    protected function check(): void
    {
        Monitor::query()
            ->get()
            ->each(function(Monitor $monitor) {
                $monitor->checkUptime();
            });
    }

    protected function process(): void
    {
        Monitor::query()
            ->whereDoesntHave('uptime')
            ->orWhereHas('uptime', function(Builder $query) {
                $query->whereNot('uptime_status', UptimeStatus::UP);
            })
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url}: {$monitor->uptime_status}";
            });
    }
}
