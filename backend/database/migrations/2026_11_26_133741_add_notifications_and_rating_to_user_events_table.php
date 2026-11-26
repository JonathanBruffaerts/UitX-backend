<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_events', function (Blueprint $table) {
            $table->boolean('checked_in')->default(false)->after('is_saved');
            $table->unsignedTinyInteger('rating')->nullable()->after('checked_in');
            $table->timestamp('day_before_notified_at')->nullable();
            $table->timestamp('checkin_notified_at')->nullable();
            $table->timestamp('review_notified_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('user_events', function (Blueprint $table) {
            $table->dropColumn([
                'checked_in',
                'rating',
                'day_before_notified_at',
                'checkin_notified_at',
                'review_notified_at',
            ]);
        });
    }
};
