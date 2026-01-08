<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * FIRMS
         * - ile naklejek = nagroda
         * - ile naklejek na start
         */
        Schema::table('firms', function (Blueprint $table) {

            if (!Schema::hasColumn('firms', 'stamps_required')) {
                $table->unsignedTinyInteger('stamps_required')
                    ->default(10)
                    ->after('program_id');
            }

            if (!Schema::hasColumn('firms', 'start_stamps')) {
                $table->unsignedTinyInteger('start_stamps')
                    ->default(0)
                    ->after('stamps_required');
            }
        });

        /**
         * LOYALTY_CARDS
         * - karta = firma + telefon
         * - jedna karta na numer w firmie
         */
        Schema::table('loyalty_cards', function (Blueprint $table) {

            if (!Schema::hasColumn('loyalty_cards', 'phone')) {
                $table->string('phone', 20)
                    ->after('client_id');
            }

            // UNIQUE: jedna karta na telefon w jednej firmie
            $table->unique(['firm_id', 'phone'], 'firm_phone_unique');
        });
    }

    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            if (Schema::hasColumn('firms', 'start_stamps')) {
                $table->dropColumn('start_stamps');
            }

            if (Schema::hasColumn('firms', 'stamps_required')) {
                $table->dropColumn('stamps_required');
            }
        });

        Schema::table('loyalty_cards', function (Blueprint $table) {
            $table->dropUnique('firm_phone_unique');

            if (Schema::hasColumn('loyalty_cards', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
