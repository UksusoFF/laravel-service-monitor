<?php

declare(strict_types=1);

namespace App\Orchid\Models\Monitor;

use App\Models\Monitor;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MonitorServicesScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'monitors' => Monitor::filters()->defaultSort('id')->paginate(),
        ];
    }

    public function layout(): iterable
    {
        return [
            MonitorListLayout::class,
        ];
    }

    public function name(): ?string
    {
        return __('Services');
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('admin.monitors.edit'),
        ];
    }
}
