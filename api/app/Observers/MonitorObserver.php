<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Enums\CertificateStatus;
use App\Models\Enums\UptimeStatus;
use App\Models\Monitor;
use App\Models\MonitorCertificateStatus;
use App\Models\MonitorUptimeStatus;

class MonitorObserver
{
    public function created(Monitor $monitor): void
    {
        $status = new MonitorUptimeStatus();
        $status->monitor_id = $monitor->id;
        $status->uptime_status = UptimeStatus::NOT_YET_CHECKED;
        $status->save();

        $status = new MonitorCertificateStatus();
        $status->monitor_id = $monitor->id;
        $status->certificate_status = CertificateStatus::NOT_YET_CHECKED;
        $status->save();
    }
}
