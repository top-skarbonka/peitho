<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loyalty_cards', function (Blueprint $table) {
            if (!Schema::hasColumn('loyalty_cards', 'firm_id')) {
                $table->unsignedBigInteger('firm_id')->nullable()->after('id');
                $table->index('firm_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('loyalty_cards', function (Blueprint $table) {
            if (Schema::hasColumn('loyalty_cards', 'firm_id')) {
                $table->dropIndex(['firm_id']);
                $table->dropColumn('firm_id');
            }
        });
    }
};
