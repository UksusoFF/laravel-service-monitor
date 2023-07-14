<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MonitorUptimeStatus
 *
 * @property int $id
 * @property int $monitor_id
 * @property string $uptime_status
 * @property string $uptime_check_failure_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
class MonitorUptimeStatus extends Model
{
}
