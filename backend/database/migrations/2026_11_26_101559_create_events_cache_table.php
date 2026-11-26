<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events_cache', function (Blueprint $table) {
            $table->string('event_id', 100)->primary();
            $table->string('title');
            $table->string('location_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('payload');
            $table->timestamp('cached_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events_cache');
    }
};
