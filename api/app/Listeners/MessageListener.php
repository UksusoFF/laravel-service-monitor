<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Interfaces\HasMessage;
use App\Services\TelegramService;

class MessageListener
{
    private function tg(): TelegramService
    {
        return app(TelegramService::class);
    }

    public function handle(HasMessage $event): void
    {
        $this->tg()->allowMarkdown()->sendMessage((string)config('telegram.chat'), $event->getMessageText());
    }
}
