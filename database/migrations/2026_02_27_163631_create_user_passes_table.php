<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_passes', function (Blueprint $table) {
            $table->id();

            // Klient (u Was jest tabela 'clients' - wg migrate:status)
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();

            // Firma, w której obowiązuje karnet
            $table->foreignId('firm_id')->constrained('firms')->cascadeOnDelete();

            // Typ karnetu z oferty firmy
            $table->foreignId('pass_type_id')->constrained('company_pass_types')->restrictOnDelete();

            // Snapshot parametrów przy zakupie (elastyczność na przyszłość)
            $table->unsignedInteger('total_entries');
            $table->unsignedInteger('remaining_entries');

            // Statusy:
            // active   - można używać
            // finished - wykorzystany (remaining_entries = 0)
            // canceled - anulowany
            $table->string('status', 20)->default('active');

            $table->timestamp('activated_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();

            // Szybkie wyszukiwanie aktywnego karnetu w firmie
            $table->index(['client_id', 'firm_id', 'status']);

            // UWAGA:
            // Nie robimy constraintu "1 active per (client_id, firm_id)" na poziomie DB,
            // bo MySQL nie wspiera partial unique index (WHERE status='active').
            // Dopniemy to w logice aplikacji (transakcja + blokada) przy zakupie/aktywacji.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_passes');
    }
};
