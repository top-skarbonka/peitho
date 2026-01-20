<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Dodanie informacji o cofnięciu zgody marketingowej (RODO)
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'sms_marketing_withdrawn_at')) {
                $table
                    ->timestamp('sms_marketing_withdrawn_at')
                    ->nullable()
                    ->after('sms_marketing_consent_at')
                    ->comment('Data i godzina cofnięcia zgody marketingowej (RODO)');
            }
        });
    }

    /**
     * Cofnięcie migracji
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'sms_marketing_withdrawn_at')) {
                $table->dropColumn('sms_marketing_withdrawn_at');
            }
        });
    }
};
