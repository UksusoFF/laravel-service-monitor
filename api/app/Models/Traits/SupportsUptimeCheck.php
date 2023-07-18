<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Events\UptimeStatusFailed;
use App\Events\UptimeStatusSucceeded;
use App\Models\Enums\UptimeStatus;
use App\Models\MonitorUptimeStatus;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Http;

trait SupportsUptimeCheck
{
    public function scopeFailedUptimeCheck(Builder $query): void
    {
        $query
            ->whereDoesntHave('uptime')
            ->orWhereHas('uptime', function(Builder $query) {
                $query->whereNot('uptime_status', UptimeStatus::UP);
            });
    }

    public function checkUptime(): void
    {
        try {
            Http::get($this->url);

            $this->ip = gethostbyname(parse_url($this->url, PHP_URL_HOST));

            $this->setUptime();
        } catch (Exception $exception) {
            $this->setUptimeException($exception);
        }
    }

    public function uptime(): HasOne
    {
        return $this->hasOne(MonitorUptimeStatus::class)->latestOfMany();
    }

    public function uptimePrevious(): HasOne
    {
        return $this->uptime()->skip(1);
    }

    public function setUptime(): void
    {
        $isStatusChanged = $this->uptime->uptime_status !== UptimeStatus::UP;

        $status = new MonitorUptimeStatus();

        $status->monitor_id = $this->id;
        $status->uptime_status = UptimeStatus::UP;

        $status->save();

        $this->save();

        if ($isStatusChanged) {
            event(new UptimeStatusSucceeded($this, $status));
        }
    }

    public function setUptimeException(Exception $exception): void
    {
        $isStatusChanged = $this->uptime->uptime_status !== UptimeStatus::DOWN;

        $status = new MonitorUptimeStatus();

        $status->monitor_id = $this->id;
        $status->uptime_status = UptimeStatus::DOWN;
        $status->uptime_check_failure_reason = $exception->getMessage();

        $status->save();

        if ($isStatusChanged) {
            event(new UptimeStatusFailed($this, $status));
        }
    }
}
