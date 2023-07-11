<?php

declare(strict_types=1);

namespace App\Orchid\Models\Monitor;

use App\Models\Monitor;
use Orchid\Screen\Screen;

class MonitorListScreen extends Screen
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
        return __('Servers');
    }
}
