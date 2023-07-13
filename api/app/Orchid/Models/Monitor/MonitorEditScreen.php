<?php

declare(strict_types=1);

namespace App\Orchid\Models\Monitor;

use App\Models\Monitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class MonitorEditScreen extends Screen
{
    public Monitor $model;

    public function query(Monitor $model): iterable
    {
        return [
            'model' => $model,
        ];
    }

    public function name(): ?string
    {
        return $this->model->exists ? 'Edit' : 'Create';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Delete'))
                ->icon('trash')
                ->confirm(__('Are you sure?'))
                ->method('delete')
                ->canSee($this->model->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            MonitorEditLayout::class,
        ];
    }

    public function save(Monitor $model, Request $request): RedirectResponse
    {
        $request->validate([
            //
        ]);

        $model->fill($request->input('model'))->save();

        Toast::info(__('Model was saved'));

        return redirect()->route('admin.monitors');
    }

    public function delete(Monitor $model): RedirectResponse
    {
        $model->delete();

        Toast::info(__('Model was removed'));

        return redirect()->route('admin.monitors');
    }
}
