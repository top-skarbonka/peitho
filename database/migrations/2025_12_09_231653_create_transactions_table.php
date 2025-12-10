<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('firm_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('points_change');   // +punkty lub -punkty
            $table->string('type');             // 'add', 'subtract'
            $table->string('description')->nullable(); // np. nazwa usługi lub kwota paragonu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
