<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            $table->uuid('registration_token')
                  ->nullable()
                  ->unique()
                  ->after('firm_id');
        });
    }

    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            $table->dropColumn('registration_token');
        });
    }
};
