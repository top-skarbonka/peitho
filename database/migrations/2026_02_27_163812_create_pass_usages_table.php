<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pass_usages', function (Blueprint $table) {
            $table->id();

            // Zużycie dotyczy konkretnego karnetu
            $table->foreignId('user_pass_id')->constrained('user_passes')->cascadeOnDelete();

            // Dla łatwego filtrowania bez joinów (denormalizacja bezpieczna)
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('firm_id')->constrained('firms')->cascadeOnDelete();

            // Kiedy wejście zostało wykorzystane
            $table->timestamp('used_at');

            // Metadane bezpieczeństwa / audytu (opcjonalne, ale bardzo przydatne)
            $table->string('ip_address', 45)->nullable();   // IPv4/IPv6
            $table->string('user_agent', 255)->nullable();

            // Skąd przyszło (na przyszłość): qr_company, panel, admin, api
            $table->string('source', 30)->default('qr_company');

            $table->timestamps();

            // Indeksy pod statystyki i szybkie listy
            $table->index(['firm_id', 'used_at']);
            $table->index(['client_id', 'used_at']);
            $table->index(['user_pass_id', 'used_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pass_usages');
    }
};
