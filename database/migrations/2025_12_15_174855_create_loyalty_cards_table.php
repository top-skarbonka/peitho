<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela już istnieje – migracja logicznie spełniona
        if (Schema::hasTable('loyalty_cards')) {
            return;
        }

        Schema::create('loyalty_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('firm_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedInteger('max_stamps');
            $table->unsignedInteger('current_stamps')->default(0);
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // NIE USUWAMY tabeli – bezpieczeństwo danych
    }
};
