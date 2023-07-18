<?php

declare(strict_types=1);

namespace App\Orchid\Models\Monitor;

use App\Models\Monitor;
use Illuminate\Support\Collection;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class MonitorServersScreen extends Screen
{
    public function query(): iterable
    {
        return Monitor::all()->groupBy('ip');
    }

    public function name(): ?string
    {
        return __('Servers');
    }

    public function layout(): iterable
    {
        return Monitor::all()
            ->groupBy('ip')
            ->map(function(Collection $items, string $ip) {
                return Layout::legend($ip, [
                    Sight::make('hostname')->render(function() use ($ip) {
                        return gethostbyaddr($ip);
                    }),
                    Sight::make('services')->render(function(Collection $items) {
                        return nl2br(implode(PHP_EOL, $items->map(function(Monitor $monitor) {
                            return $monitor->url;
                        })->toArray()));
                    }),
                ])->title($ip);
            });
    }
}
