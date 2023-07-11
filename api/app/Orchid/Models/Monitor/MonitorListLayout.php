<?php

declare(strict_types=1);

namespace App\Orchid\Models\Monitor;

use App\Models\Monitor;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MonitorListLayout extends Table
{
    public $target = 'monitors';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', __('ID')),
            TD::make('url', __('URL')),
            TD::make('cert', __('Certificate'))
                ->render(function (Monitor $monitor) {
                    return view('admin.td.status', [
                        'status' => $monitor->certificate_status,
                    ]);
                }),
            TD::make('cert_date', __('Last check'))->render(fn(Monitor $monitor) => $monitor->certificateStatuses->first()?->created_at),
        ];
    }
}
