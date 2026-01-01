<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_tokens', function (Blueprint $table) {
            $table->id();

            // unikalny token do rejestracji klienta
            $table->string('token')->unique();

            // firma, do której należy token
            $table->foreignId('firm_id')
                ->constrained('firms')
                ->cascadeOnDelete();

            // opcjonalna data wygaśnięcia
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_tokens');
    }
};
