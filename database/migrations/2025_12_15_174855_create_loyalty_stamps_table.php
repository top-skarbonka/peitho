<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela już istnieje – migracja logicznie wykonana
        if (Schema::hasTable('loyalty_stamps')) {
            return;
        }

        Schema::create('loyalty_stamps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loyalty_card_id');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // NIE usuwamy tabeli – bezpieczeństwo danych
    }
};
