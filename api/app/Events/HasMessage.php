<?php

declare(strict_types=1);

namespace App\Events;

interface HasMessage
{
    public function getMessageText(): string;
}
