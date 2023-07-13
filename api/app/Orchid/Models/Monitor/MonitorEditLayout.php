<?php

declare(strict_types=1);

namespace App\Orchid\Models\Monitor;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class MonitorEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('model.group')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Group')),

            Input::make('model.url')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('URL')),
        ];
    }
}
