<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            // Stały token do QR karnetów
            $table->string('pass_qr_token', 64)
                  ->nullable()
                  ->unique()
                  ->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            $table->dropUnique(['pass_qr_token']);
            $table->dropColumn('pass_qr_token');
        });
    }
};
