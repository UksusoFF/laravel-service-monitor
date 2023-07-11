<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Spatie\UptimeMonitor\Models\Enums\UptimeStatus;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('monitors', function(Blueprint $table) {
            $table->increments('id');
            $table->string('url')->unique();

            $table->boolean('uptime_check_enabled')->default(true);
            $table->string('look_for_string')->default('');
            $table->string('uptime_check_interval_in_minutes')->default(5);
            $table->string('uptime_status')->default(UptimeStatus::NOT_YET_CHECKED);
            $table->text('uptime_check_failure_reason')->nullable();
            $table->integer('uptime_check_times_failed_in_a_row')->default(0);
            $table->timestamp('uptime_status_last_change_date')->nullable();
            $table->timestamp('uptime_last_check_date')->nullable();
            $table->timestamp('uptime_check_failed_event_fired_on_date')->nullable();
            $table->string('uptime_check_method')->default('get');
            $table->text('uptime_check_payload')->nullable();
            $table->text('uptime_check_additional_headers')->nullable();
            $table->string('uptime_check_response_checker')->nullable();

            $table->boolean('certificate_check_enabled')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('monitors');
    }
};
