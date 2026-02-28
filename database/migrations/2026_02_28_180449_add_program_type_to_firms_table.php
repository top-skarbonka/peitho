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
        Schema::table('firms', function (Blueprint $table) {
            $table->string('program_type')
                ->default('cards')
                ->after('pass_qr_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            $table->dropColumn('program_type');
        });
    }
};
