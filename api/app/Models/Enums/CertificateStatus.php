<?php

declare(strict_types=1);

namespace App\Models\Enums;

class CertificateStatus
{
    public const NOT_YET_CHECKED = 'not yet checked';

    public const VALID = 'valid';

    public const INVALID = 'invalid';
}
