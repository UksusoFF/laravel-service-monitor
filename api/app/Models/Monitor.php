<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SupportsCertificateCheck;
use App\Models\Traits\SupportsUptimeCheck;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/**
 * App\Models\Monitor
 *
 * @property int $id
 * @property string $url
 * @property string|null $group
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MonitorCertificateStatus|null $certificate
 * @property-read \App\Models\MonitorCertificateStatus|null $certificatePrevious
 * @property-read \App\Models\MonitorUptimeStatus|null $uptime
 * @property-read \App\Models\MonitorUptimeStatus|null $uptimePrevious
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor failedCertificateCheck()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor failedUptimeCheck()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUrl($value)
 * @mixin \Eloquent
 */
class Monitor extends Model
{
    use AsSource;
    use SupportsCertificateCheck;
    use SupportsUptimeCheck;

    protected $fillable = [
        'url',
        'group',
    ];
}
