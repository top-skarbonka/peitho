<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->boolean('email_marketing_consent')->default(false)->after('sms_marketing_withdrawn_at');
            $table->timestamp('email_marketing_consent_at')->nullable()->after('email_marketing_consent');
            $table->timestamp('email_marketing_withdrawn_at')->nullable()->after('email_marketing_consent_at');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'email_marketing_consent',
                'email_marketing_consent_at',
                'email_marketing_withdrawn_at',
            ]);
        });
    }
};
