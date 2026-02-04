<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('firms', function (Blueprint $table) {

            $table->string('subscription_forced_status')
                ->nullable()
                ->after('subscription_status');

        });
    }

    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {

            $table->dropColumn('subscription_forced_status');

        });
    }
};
