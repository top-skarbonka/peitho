<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('firms', function (Blueprint $table) {

            $table->boolean('has_stickers')
                ->default(false)
                ->after('plan_id');

            $table->boolean('has_points')
                ->default(false)
                ->after('has_stickers');

            $table->boolean('has_passes')
                ->default(false)
                ->after('has_points');

        });
    }

    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {

            $table->dropColumn('has_stickers');
            $table->dropColumn('has_points');
            $table->dropColumn('has_passes');

        });
    }
};
