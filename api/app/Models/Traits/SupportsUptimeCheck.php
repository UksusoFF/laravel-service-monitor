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

    public function getUptimeStatusAttribute(): string
    {
        return $this->uptime?->uptime_status ?? UptimeStatus::NOT_YET_CHECKED;
    }

    public function setUptimeCheckFailureReasonAttribute(string $reason): void
    {
        /** @var \App\Models\MonitorUptimeStatus $status */
        $status = $this->uptime()->get();

        $status->uptime_status = $reason;

        $status->save();
    }

    public function setUptime(): void
    {
        $isStatusChanged = ($this->uptime?->uptime_status ?? null) !== UptimeStatus::UP;

        $status = new MonitorUptimeStatus();

        $status->monitor_id = $this->id;
        $status->uptime_status = UptimeStatus::UP;

        $status->save();

        if ($isStatusChanged) {
            event(new UptimeStatusSucceeded($this, $status));
        }
    }

    public function setUptimeException(Exception $exception): void
    {
        $isStatusChanged = ($this->uptime?->uptime_status ?? null) !== UptimeStatus::DOWN;

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
