<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('monitor_certificate_statuses', function(Blueprint $table) {
            $table->increments('id');

            $table->foreignId('monitor_id')->nullable(false)->references('id')->on('monitors')->cascadeOnDelete();

            $table->string('certificate_status')->nullable();
            $table->timestamp('certificate_expiration_date')->nullable();
            $table->string('certificate_issuer')->nullable();
            $table->string('certificate_check_failure_reason')->default('');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('monitor_certificate_statuses');
    }
};
