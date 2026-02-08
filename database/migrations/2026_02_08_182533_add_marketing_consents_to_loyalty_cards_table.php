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

            // ✅ ZGODA MARKETINGOWA – PER KARTA / PER FIRMA (RODO)
            $table->boolean('marketing_consent')->default(true);

            $table->timestamp('marketing_consent_at')->nullable();

            $table->timestamp('marketing_consent_revoked_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loyalty_cards', function (Blueprint $table) {
            $table->dropColumn([
                'marketing_consent',
                'marketing_consent_at',
                'marketing_consent_revoked_at',
            ]);
        });
    }
};
