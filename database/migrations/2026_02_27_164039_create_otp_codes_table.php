<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();

            // Firma (QR firmy)
            $table->foreignId('firm_id')->constrained('firms')->cascadeOnDelete();

            // Klient
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();

            // Numer telefonu
            $table->string('phone', 32);

            // Hash kodu OTP (NIGDY plain text)
            $table->string('code_hash', 255);

            // Licznik prób (max 3)
            $table->unsignedTinyInteger('attempts')->default(0);

            // Wygasa po 3 minutach
            $table->timestamp('expires_at');

            // Użyty kod
            $table->timestamp('used_at')->nullable();

            // Unieważniony (gdy wygenerujemy nowy)
            $table->timestamp('revoked_at')->nullable();

            $table->timestamps();

            $table->index(['firm_id', 'phone']);
            $table->index(['client_id', 'firm_id']);
            $table->index(['expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
