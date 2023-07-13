<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SupportsCertificateCheck;
use Orchid\Screen\AsSource;

/**
 * App\Models\Monitor
 *
 * @property int $id
 * @property \Spatie\Url\Url|null $url
 * @property string|null $group
 * @property bool $uptime_check_enabled
 * @property string $look_for_string
 * @property string $uptime_check_interval_in_minutes
 * @property string $uptime_status
 * @property string|null $uptime_check_failure_reason
 * @property int $uptime_check_times_failed_in_a_row
 * @property \Illuminate\Support\Carbon|null $uptime_status_last_change_date
 * @property \Illuminate\Support\Carbon|null $uptime_last_check_date
 * @property \Illuminate\Support\Carbon|null $uptime_check_failed_event_fired_on_date
 * @property string $uptime_check_method
 * @property string|null $uptime_check_payload
 * @property array $uptime_check_additional_headers
 * @property string|null $uptime_check_response_checker
 * @property bool $certificate_check_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MonitorCertificateStatus|null $certificate
 * @property-read \App\Models\MonitorCertificateStatus|null $certificatePrevious
 * @property-read string $certificate_status_as_emoji
 * @property-read string $certificate_status
 * @property-read string $chunked_last_certificate_check_failure_reason
 * @property-read string $chunked_last_failure_reason
 * @property-read string $raw_url
 * @property-read string $uptime_status_as_emoji
 * @property-write mixed $certificate_check_failure_reason
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereCertificateCheckEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereLookForString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeCheckAdditionalHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeCheckEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeCheckFailedEventFiredOnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeCheckFailureReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeCheckIntervalInMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeCheckMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeCheckPayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeCheckResponseChecker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeCheckTimesFailedInARow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeLastCheckDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUptimeStatusLastChangeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUrl($value)
 * @mixin \Eloquent
 */
class Monitor extends \Spatie\UptimeMonitor\Models\Monitor
{
    use AsSource;
    use SupportsCertificateCheck;

    protected $fillable = [
        'url',
        'group',
    ];
}
