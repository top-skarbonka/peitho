<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            // Przelicznik punktów, np. 0.5 = 1 zł → 0.5 pkt, 1 = 1 zł → 1 pkt
            $table->decimal('points_rate', 8, 2)->default(1.00)->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('points_rate');
        });
    }
};
