<?php

declare(strict_types=1);

use App\Models\Enums\UptimeStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('monitor_uptime_statuses', function(Blueprint $table) {
            $table->increments('id');

            $table->foreignId('monitor_id')->nullable(false)->references('id')->on('monitors')->cascadeOnDelete();

            $table->string('uptime_status')->default(UptimeStatus::NOT_YET_CHECKED->value);
            $table->longText('uptime_check_failure_reason')->default('');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('monitor_uptime_statuses');
    }
};
