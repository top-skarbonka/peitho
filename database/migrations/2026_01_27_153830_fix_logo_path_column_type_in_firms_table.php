<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->change();
        });
    }

    public function down(): void
    {
        // brak cofania – wcześniej kolumna i tak była błędna
    }
};
