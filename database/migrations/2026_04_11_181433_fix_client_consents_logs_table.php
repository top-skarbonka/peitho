<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_consents_logs', function (Blueprint $table) {

            if (!Schema::hasColumn('client_consents_logs', 'client_id')) {
                $table->unsignedBigInteger('client_id')->after('id');
            }

            if (!Schema::hasColumn('client_consents_logs', 'firm_id')) {
                $table->unsignedBigInteger('firm_id')->after('client_id');
            }

            if (!Schema::hasColumn('client_consents_logs', 'consent_type')) {
                $table->string('consent_type')->after('firm_id');
            }

            if (!Schema::hasColumn('client_consents_logs', 'value')) {
                $table->boolean('value')->after('consent_type');
            }

        });
    }

    public function down(): void
    {
        Schema::table('client_consents_logs', function (Blueprint $table) {

            if (Schema::hasColumn('client_consents_logs', 'client_id')) {
                $table->dropColumn('client_id');
            }

            if (Schema::hasColumn('client_consents_logs', 'firm_id')) {
                $table->dropColumn('firm_id');
            }

            if (Schema::hasColumn('client_consents_logs', 'consent_type')) {
                $table->dropColumn('consent_type');
            }

            if (Schema::hasColumn('client_consents_logs', 'value')) {
                $table->dropColumn('value');
            }

        });
    }
};
