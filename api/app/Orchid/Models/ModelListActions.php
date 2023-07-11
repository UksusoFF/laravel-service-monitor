<?php

declare(strict_types=1);

namespace App\Orchid\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class ModelListActions
{
    public function __construct(
        protected string $route
    ) {
        //
    }

    public function build(): TD
    {
        return TD::make(__('Actions'))
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(fn(Model $model) => DropDown::make()
                ->icon('options-vertical')
                ->list([
                    Link::make(__('Edit'))
                        ->route("{$this->route}.edit", $model->{$model->getKeyName()})
                        ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Are you sure?'))
                        ->action(route("{$this->route}.edit", $model->{$model->getKeyName()}).'/delete'),
                ]));
    }
}
