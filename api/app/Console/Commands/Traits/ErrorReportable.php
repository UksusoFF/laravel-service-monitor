<?php

declare(strict_types=1);

namespace App\Console\Commands\Traits;

use App\Services\TelegramService;

trait ErrorReportable
{
    protected array $errors = [];

    private function tg(): TelegramService
    {
        return app(TelegramService::class);
    }

    public function errorReport(): void
    {
        if (empty($this->errors)) {
            return;
        }

        $lines = array_merge([
            "⚠️ Во время выполнения команды `{$this->signature}` произошли ошибки!",
            PHP_EOL,
            'Сервер: ' . config('app.url'),
            'Сообщения:',
        ], $this->errors);

        foreach ($lines as $line) {
            $this->warn($line);
        }

        $this->tg()->allowMarkdown()->sendMessage((string)config('telegram.chat'), implode(PHP_EOL, $lines));
    }
}
