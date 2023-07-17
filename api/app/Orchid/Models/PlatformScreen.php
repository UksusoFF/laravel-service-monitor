<?php

declare(strict_types=1);

namespace App\Orchid\Models;

use App\Models\Monitor;
use App\Orchid\Models\Monitor\MonitorListLayout;
use App\Orchid\Models\Monitor\MonitorListScreen;
use App\Services\MegafonService;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends MonitorListScreen
{
    public function query(): iterable
    {
        return [
            'monitors' => Monitor::paginate(),
            'metrics' => [
                'megafon' => app(MegafonService::class)->balance(),
            ],
        ];
    }

    public function name(): ?string
    {
        return 'Dashboard';
    }

    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Megafon' => 'metrics.megafon',
            ]),
            MonitorListLayout::class,
        ];
    }
}
