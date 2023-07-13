<?php

declare(strict_types=1);

namespace App\Checks;

use App\Services\MegafonService;

class MegafonCheck
{
    public CheckStatus $status = CheckStatus::SUCCESS;

    protected array $thresholds = [
        5000 => CheckStatus::DANGER,
        10000 => CheckStatus::WARNING,
    ];

    public function __construct(
        protected MegafonService $megafon,
    ) {
        //
    }

    public function check(): void
    {
        $balance = $this->megafon->balance();

        foreach ($this->thresholds as $key => $value) {
            if ($balance < $key) {
                $this->status = $value;
                return;
            }
        }

        $this->status = CheckStatus::SUCCESS;
    }

    public function getMessageText(): string
    {
        return "{$this->status->emoji()} Статус проверки баланса МегаФон: {$this->megafon->balance()}";
    }
}
