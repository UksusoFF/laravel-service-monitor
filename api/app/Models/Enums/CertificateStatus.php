<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum CertificateStatus: string
{
    case INVALID = 'invalid';
    case NOT_YET_CHECKED = 'not yet checked';
    case VALID = 'valid';

    public function emoji(): string
    {
        return match($this) {
            self::INVALID => '🚨',
            self::NOT_YET_CHECKED => '⚠️',
            self::VALID => '✅',
        };
    }
}
