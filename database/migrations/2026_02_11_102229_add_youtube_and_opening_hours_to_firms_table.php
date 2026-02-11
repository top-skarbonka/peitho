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

            if (!Schema::hasColumn('firms', 'youtube_url')) {
                $table->string('youtube_url')->nullable()->after('instagram_url');
            }

            if (!Schema::hasColumn('firms', 'opening_hours')) {
                $table->text('opening_hours')->nullable()->after('promotion_text');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {

            if (Schema::hasColumn('firms', 'youtube_url')) {
                $table->dropColumn('youtube_url');
            }

            if (Schema::hasColumn('firms', 'opening_hours')) {
                $table->dropColumn('opening_hours');
            }

        });
    }
};
