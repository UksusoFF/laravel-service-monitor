<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\CertificateStatusFailed;
use App\Events\CertificateStatusSucceeded;
use App\Listeners\MessageListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CertificateStatusFailed::class => [
            MessageListener::class,
        ],
        CertificateStatusSucceeded::class => [
            MessageListener::class,
        ],
    ];
}
