<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_consents_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('client_consents_logs', 'phone')) {
                $table->string('phone')->nullable()->after('client_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('client_consents_logs', function (Blueprint $table) {
            if (Schema::hasColumn('client_consents_logs', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
