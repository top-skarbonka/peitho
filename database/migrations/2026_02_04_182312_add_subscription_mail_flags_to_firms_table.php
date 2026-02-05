<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * RUN MIGRATION
     */
    public function up(): void
    {
        Schema::table('firms', function (Blueprint $table) {

            $table->timestamp('subscription_reminder_sent_at')->nullable();
            $table->timestamp('subscription_expired_sent_at')->nullable();
            $table->timestamp('subscription_blocked_sent_at')->nullable();

        });
    }

    /**
     * ROLLBACK
     */
    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {

            $table->dropColumn([
                'subscription_reminder_sent_at',
                'subscription_expired_sent_at',
                'subscription_blocked_sent_at'
            ]);

        });
    }
};
