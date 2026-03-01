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
        Schema::create('pass_entry_logs', function (Blueprint $table) {
            $table->id();

            // Firma
            $table->unsignedBigInteger('firm_id');

            // Klient (może być null przy próbie bez karnetu)
            $table->unsignedBigInteger('client_id')->nullable();

            // Numer telefonu wpisany przy wejściu
            $table->string('phone', 32);

            // Karnet (może być null jeśli brak aktywnego)
            $table->unsignedBigInteger('pass_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS WEJŚCIA
            |--------------------------------------------------------------------------
            | success      – wejście poprawne
            | no_pass      – brak aktywnego karnetu
            | finished     – karnet wyczerpany
            | rejected     – inne odrzucenie
            */
            $table->string('status', 20);

            // Ile wejść zostało po operacji (jeśli success)
            $table->integer('remaining_after')->nullable();

            $table->timestamps();

            // Indeksy pod wydajność panelu
            $table->index('firm_id');
            $table->index('client_id');
            $table->index('pass_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pass_entry_logs');
    }
};
