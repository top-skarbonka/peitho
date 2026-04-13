<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loyalty_cards', function (Blueprint $table) {
            $table->boolean('sms_marketing_consent')->default(false)->after('marketing_consent_revoked_at');
            $table->timestamp('sms_marketing_consent_at')->nullable()->after('sms_marketing_consent');
            $table->timestamp('sms_marketing_consent_revoked_at')->nullable()->after('sms_marketing_consent_at');

            $table->boolean('email_marketing_consent')->default(false)->after('sms_marketing_consent_revoked_at');
            $table->timestamp('email_marketing_consent_at')->nullable()->after('email_marketing_consent');
            $table->timestamp('email_marketing_consent_revoked_at')->nullable()->after('email_marketing_consent_at');
        });
    }

    public function down(): void
    {
        Schema::table('loyalty_cards', function (Blueprint $table) {
            $table->dropColumn([
                'sms_marketing_consent',
                'sms_marketing_consent_at',
                'sms_marketing_consent_revoked_at',
                'email_marketing_consent',
                'email_marketing_consent_at',
                'email_marketing_consent_revoked_at',
            ]);
        });
    }
};
