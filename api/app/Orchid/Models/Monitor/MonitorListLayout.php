<?php

declare(strict_types=1);

namespace App\Orchid\Models\Monitor;

use App\Models\Monitor;
use App\Orchid\Models\ModelListActions;
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
            TD::make('group')->sort(),
            TD::make('url', __('URL')),
            TD::make('status', __('Status'))
                ->render(function(Monitor $monitor) {
                    return view('admin.td.status', [
                        'status' => $monitor->uptime_status,
                    ]);
                }),
            TD::make('status_date', __('Last check'))->render(fn(Monitor $monitor) => $monitor->uptime?->created_at?->diffForHumans()),
            TD::make('cert', __('Certificate'))
                ->render(function(Monitor $monitor) {
                    return view('admin.td.status', [
                        'status' => $monitor->certificate_status,
                    ]);
                }),
            TD::make('cert_date', __('Last check'))->render(fn(Monitor $monitor) => $monitor->certificate?->created_at?->diffForHumans()),
            (new ModelListActions('admin.monitors'))->build(),
        ];
    }
}
