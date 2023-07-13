<?php

declare(strict_types=1);

namespace App\Checks;

enum CheckStatus: string
{
    case DANGER = 'DANGER';
    case WARNING = 'WARNING';
    case SUCCESS = 'SUCCESS';

    public function emoji(): string
    {
        return match($this) {
            self::DANGER => '🚨',
            self::WARNING => '⚠️',
            self::SUCCESS => '✅',
        };
    }
}
