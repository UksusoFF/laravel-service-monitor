<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum CertificateStatus: string
{
    case EXPIRING = 'expiring';
    case INVALID = 'invalid';
    case NOT_YET_CHECKED = 'not yet checked';
    case VALID = 'valid';

    public function emoji(): string
    {
        return match($this) {
            self::EXPIRING => '⚠️',
            self::INVALID => '🚨',
            self::NOT_YET_CHECKED => '⚠️',
            self::VALID => '✅',
        };
    }

    public function priority(): string
    {
        return match($this) {
            self::EXPIRING => 'warning',
            self::INVALID => 'danger',
            self::NOT_YET_CHECKED => 'warning',
            self::VALID => 'success',
        };
    }
}
