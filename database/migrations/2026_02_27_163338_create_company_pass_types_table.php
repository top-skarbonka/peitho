<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_pass_types', function (Blueprint $table) {
            $table->id();

            // Firma, która oferuje dany rodzaj karnetu
            $table->foreignId('firm_id')->constrained('firms')->cascadeOnDelete();

            // Nazwa karnetu (np. "Karnet 10 wejść")
            $table->string('name', 100);

            // Ilość wejść w pakiecie
            $table->unsignedInteger('entries');

            // Cena brutto w groszach (opcjonalnie)
            $table->unsignedInteger('price_gross_cents')->nullable();

            // Czy aktywny w ofercie
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['firm_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_pass_types');
    }
};
