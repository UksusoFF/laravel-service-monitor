<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum UptimeStatus: string
{
    case DOWN = 'down';
    case NOT_YET_CHECKED = 'not yet checked';
    case UP = 'up';

    public function emoji(): string
    {
        return match($this) {
            self::DOWN => '🚨',
            self::NOT_YET_CHECKED => '⚠️',
            self::UP => '✅',
        };
    }

    public function priority(): string
    {
        return match($this) {
            self::DOWN => 'danger',
            self::NOT_YET_CHECKED => 'warning',
            self::UP => 'success',
        };
    }
}
