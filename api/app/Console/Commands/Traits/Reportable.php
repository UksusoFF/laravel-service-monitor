<?php

declare(strict_types=1);

namespace App\Console\Commands\Traits;

use App\Services\TelegramService;

trait Reportable
{
    protected array $messages = [];

    private function tg(): TelegramService
    {
        return app(TelegramService::class);
    }

    public function errorReport(): void
    {
        if (empty($this->messages)) {
            return;
        }

        $lines = array_merge([
            'Сервер: ' . config('app.url'),
            'Сообщения:',
        ], $this->messages);

        foreach ($lines as $line) {
            $this->warn($line);
        }

        $this->tg()->allowMarkdown()->sendMessage((string)config('telegram.chat'), implode(PHP_EOL, $lines));
    }
}
