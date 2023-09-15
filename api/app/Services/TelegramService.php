<?php

declare(strict_types=1);

namespace App\Services;

use Longman\TelegramBot\Request as TelegramRequest;
use Longman\TelegramBot\Telegram;
use Throwable;

class TelegramService
{
    protected bool $markdown = false;

    protected function createTelegram(): Telegram
    {
        return new Telegram(config('telegram.key'), config('telegram.name'));
    }

    public function allowMarkdown(): self
    {
        $this->markdown = true;

        return $this;
    }

    public function sendMessage(string $chat, string $text): void
    {
        if (config('app.debug')) {
            return;
        }

        if (empty(config('telegram.key')) || empty(config('telegram.name'))) {
            return;
        }

        try {
            $this->createTelegram();

            $properties = [
                'chat_id' => $chat,
                'text' => $text,
                'disable_web_page_preview' => true,
            ];

            if ($this->markdown) {
                $properties['parse_mode'] = 'markdown';
            }

            TelegramRequest::sendMessage($properties);
        } catch (Throwable $e) {
            report($e);

            logger()->debug("Failed with message: {$e->getMessage()} and code: {$e->getCode()}");
        }
    }
}
