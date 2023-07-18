<?php

declare(strict_types=1);

namespace App\Orchid\Models\Check;

use App\Models\Monitor;
use App\Orchid\Models\Monitor\MonitorListLayout;
use Orchid\Screen\Screen;

class CheckMetricsScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'monitors' => Monitor::paginate(),
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
}
