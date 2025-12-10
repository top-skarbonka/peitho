<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loyalty_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');

            $table->integer('max_stamps')->default(10);  // ile naklejek potrzeba
            $table->integer('current_stamps')->default(0); // ile naklejek już jest
            $table->string('reward')->nullable(); // nagroda (np. "darmowa usługa")

            $table->string('qr_code')->unique(); // kod QR przypisany do karty
            $table->enum('status', ['active', 'completed', 'reset'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loyalty_cards');
    }
};
