<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loyalty_cards', function (Blueprint $table) {
            $table->boolean('push_consent')->default(false)->after('email_marketing_consent_revoked_at');
            $table->timestamp('push_consent_at')->nullable()->after('push_consent');
            $table->timestamp('push_consent_revoked_at')->nullable()->after('push_consent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loyalty_cards', function (Blueprint $table) {
            $table->dropColumn([
                'push_consent',
                'push_consent_at',
                'push_consent_revoked_at',
            ]);
        });
    }
};
