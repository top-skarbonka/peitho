<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('name')->nullable()->after('email');
            $table->boolean('sms_marketing_consent')->default(false)->after('postal_code');
            $table->timestamp('sms_marketing_consent_at')->nullable()->after('sms_marketing_consent');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'sms_marketing_consent',
                'sms_marketing_consent_at',
            ]);
        });
    }
};
