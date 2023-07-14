<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Enums\CertificateStatus;
use App\Models\Monitor;
use Illuminate\Database\Eloquent\Builder;

class MonitorCheckCertificateCommand extends AbstractMonitorCommand
{
    protected $signature = 'monitor:check-certificate';

    protected $description = 'Command checks certificate';

    protected function check(): void
    {
        Monitor::query()
            ->get()
            ->each(function(Monitor $monitor) {
                $monitor->checkCertificate();
            });
    }

    protected function process(): void
    {
        Monitor::query()
            ->whereDoesntHave('certificate')
            ->orWhereHas('certificate', function(Builder $query) {
                $query->whereNot('certificate_status', CertificateStatus::VALID);
            })
            ->get()
            ->each(function(Monitor $monitor) {
                $this->errors[] = "{$monitor->url}: {$monitor->certificate_status}";
            });
    }
}
