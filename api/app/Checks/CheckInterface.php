<?php

declare(strict_types=1);

namespace App\Checks;

interface CheckInterface
{
    public function check(): void;

    public function shouldBeReported(): bool;

    public function getMessageText(): string;

    public function getValueText(): string;

    public function getStatusText(): string;
}
