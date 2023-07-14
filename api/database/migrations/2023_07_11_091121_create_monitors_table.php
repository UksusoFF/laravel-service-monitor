<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('monitors', function(Blueprint $table) {
            $table->increments('id');

            $table->string('url')->unique();
            $table->string('group')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('monitors');
    }
};
