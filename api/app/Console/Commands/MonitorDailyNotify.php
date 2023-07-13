<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\Commands\Traits\ErrorReportable;
use App\Models\Monitor;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Spatie\UptimeMonitor\Models\Enums\CertificateStatus;
use Spatie\UptimeMonitor\Models\Enums\UptimeStatus;

class MonitorDailyNotify extends Command
{
    use ErrorReportable;

    protected $signature = 'monitor:daily-notify';

    protected $description = 'Command notify about daily incidents';

    public function handle(): int
    {
        $this->checkCertificates();

        $this->checkUptime();

        $this->errorReport();

        return Command::SUCCESS;
    }

    protected function checkCertificates(): void
    {
        Monitor::query()
            ->whereDoesntHave('certificate')
            ->orWhereHas('certificate', function(Builder $query) {
                $query->whereNot('certificate_status', CertificateStatus::VALID);
            })
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url->getHost()}: {$monitor->certificate_status}";
            });
    }

    protected function checkUptime(): void
    {
        Monitor::query()
            ->whereNot('uptime_status', UptimeStatus::UP)
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url->getHost()}: {$monitor->uptime_status}";
            });
    }
}
