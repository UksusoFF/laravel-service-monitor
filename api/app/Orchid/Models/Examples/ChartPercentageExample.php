<?php

declare(strict_types=1);

namespace App\Orchid\Models\Examples;

use Orchid\Screen\Layouts\Chart;

class ChartPercentageExample extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = self::TYPE_PERCENTAGE;

    /**
     * @var int
     */
    protected $height = 160;
}
