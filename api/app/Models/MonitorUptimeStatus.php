<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\HasMessage;
use App\Models\Enums\UptimeStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MonitorUptimeStatus
 *
 * @property int $id
 * @property int $monitor_id
 * @property UptimeStatus $uptime_status
 * @property string $uptime_check_failure_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Monitor $monitor
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorUptimeStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorUptimeStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorUptimeStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorUptimeStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorUptimeStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorUptimeStatus whereMonitorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorUptimeStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorUptimeStatus whereUptimeCheckFailureReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorUptimeStatus whereUptimeStatus($value)
 * @mixin \Eloquent
 */
class MonitorUptimeStatus extends Model implements HasMessage
{
    protected $casts = [
        'uptime_status' => UptimeStatus::class,
    ];

    public function monitor(): BelongsTo
    {
        return $this->belongsTo(Monitor::class);
    }

    public function getMessageText(): string
    {
        return "{$this->uptime_status->emoji()} {$this->monitor->url}: {$this->uptime_status->value}";
    }
}
