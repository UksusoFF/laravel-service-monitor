<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use Orchid\Screen\Fields\TextArea;

class Markdown extends TextArea
{
    protected $attributes = [
        'class' => 'form-control no-resize',
        'popover' => 'Field support markdown syntax: https://www.markdownguide.org/basic-syntax/',
        'value' => null,
    ];
}
