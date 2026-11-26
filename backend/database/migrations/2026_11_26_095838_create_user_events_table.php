<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_events', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('event_id', 100);
            $table->boolean('is_going')->default(false);
            $table->boolean('is_saved')->default(false);
            $table->boolean('reminder_sent')->default(false);
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->primary(['user_id', 'event_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index(['event_id', 'is_going'], 'idx_user_events_event_going');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_events');
    }
};
