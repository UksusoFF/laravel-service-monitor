<?php

declare(strict_types=1);

namespace App\Checks;

use App\Services\MegafonService;
use Exception;

class MegafonCheck implements CheckInterface
{
    public CheckStatus $status = CheckStatus::DANGER;

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
        try {
            $balance = $this->megafon->balance();
        } catch (Exception $e) {
            report($e);

            $this->status = CheckStatus::DANGER;

            return;
        }

        foreach ($this->thresholds as $key => $value) {
            if ($balance < $key) {
                $this->status = $value;
                return;
            }
        }

        $this->status = CheckStatus::SUCCESS;
    }

    public function shouldBeReported(): bool
    {
        return $this->status !== CheckStatus::SUCCESS;
    }

    public function getMessageText(): string
    {
        return "{$this->status->emoji()} Статус проверки баланса МегаФон: {$this->getStatus()}";
    }

    public function getValueText(): string
    {
        try {
            $balance = $this->megafon->balance();
        } catch (Exception $e) {
            report($e);

            return (string) 0;
        }

        return (string) $balance;
    }

    public function getStatusText(): string
    {
        return $this->status->name;
    }

    private function getStatus(): string
    {
        try {
            $balance = $this->megafon->balance();
        } catch (Exception $e) {
            report($e);

            return $e->getMessage();
        }

        return (string) $balance;
    }
}
