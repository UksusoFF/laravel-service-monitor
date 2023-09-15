<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enums\CertificateStatus;
use App\Models\Enums\UptimeStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MonitorCertificateStatus
 *
 * @property int $id
 * @property int $monitor_id
 * @property CertificateStatus $certificate_status
 * @property \Illuminate\Support\Carbon|null $certificate_expiration_date
 * @property string|null $certificate_issuer
 * @property string $certificate_check_failure_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Monitor $monitor
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus whereCertificateCheckFailureReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus whereCertificateExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus whereCertificateIssuer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus whereCertificateStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus whereMonitorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonitorCertificateStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MonitorCertificateStatus extends Model
{
    protected $casts = [
        'certificate_expiration_date' => 'datetime',
        'certificate_status' => CertificateStatus::class,
    ];

    public function monitor(): BelongsTo
    {
        return $this->belongsTo(Monitor::class);
    }

    public function isExpiring(): bool
    {
        if ($this->certificate_expiration_date === null) {
            return false;
        }

        return $this->certificate_expiration_date->lessThan(Carbon::now()->addWeek());
    }

    public function getMessageText(): string
    {
        if ($this->isExpiring()) {
            $emoji = UptimeStatus::NOT_YET_CHECKED->emoji();

            return "{$emoji} {$this->monitor->url}: expiring at {$this->certificate_expiration_date->diffForHumans()}";
        }

        return "{$this->certificate_status->emoji()} {$this->monitor->url}: {$this->certificate_status->value}";
    }
}
