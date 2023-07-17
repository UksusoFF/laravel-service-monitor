<?php

declare(strict_types=1);

namespace App\Orchid\Models;

use App\Checks\CheckInterface;
use App\Checks\CheckRepository;
use App\Models\Monitor;
use App\Orchid\Models\Monitor\MonitorListLayout;
use Illuminate\Support\Collection;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class DashboardScreen extends Screen
{
    public function __construct(
        protected CheckRepository $checks
    ) {
        //
    }

    protected function getMetrics(): Collection
    {
        return collect($this->checks->all())
            ->each(function(CheckInterface $check) {
                $check->check();
            });
    }

    public function query(): iterable
    {
        return [
            'monitors' => Monitor::paginate(),
            'metrics' => $this->getMetrics()->mapWithKeys(function(CheckInterface $check) {
                return [class_basename($check) => $check->getValueText()];
            }),
        ];
    }

    public function layout(): iterable
    {
        $metrics = $this->getMetrics()
            ->mapWithKeys(function(CheckInterface $check) {
                $title = str_replace('Check', '', class_basename($check));
                $key = 'metrics.'.class_basename($check);

                return [$title => $key];
            })
            ->toArray();

        return [
            Layout::metrics($metrics),
            MonitorListLayout::class,
        ];
    }

    public function name(): ?string
    {
        return __('Dashboard');
    }
}
