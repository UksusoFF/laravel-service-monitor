<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MonitorCertificateStatus
 *
 * @property int $id
 * @property int $monitor_id
 * @property string $certificate_status
 * @property \Illuminate\Support\Carbon|null $certificate_expiration_date
 * @property string|null $certificate_issuer
 * @property string $certificate_check_failure_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
    ];
}
