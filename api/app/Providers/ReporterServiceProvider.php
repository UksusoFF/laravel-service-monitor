<?php

declare(strict_types=1);

namespace App\Providers;

use Bugsnag\BugsnagLaravel\BugsnagServiceProvider;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class ReporterServiceProvider extends BugsnagServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Bugsnag::setAppVersion(config('version.date'));
    }
}
