<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('monitor_uptime_statuses', function(Blueprint $table) {
            $table->longText('uptime_check_failure_reason')->change();
        });

        Schema::table('monitor_certificate_statuses', function(Blueprint $table) {
            $table->longText('certificate_check_failure_reason')->change();
        });
    }

    public function down(): void
    {
        //
    }
};
