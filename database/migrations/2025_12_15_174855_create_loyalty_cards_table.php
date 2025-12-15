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

            $table->unsignedBigInteger('firm_id');
            $table->unsignedBigInteger('client_id');

            // ile wizyt potrzeba
            $table->unsignedInteger('max_stamps');

            // ile aktualnie zebrano
            $table->unsignedInteger('current_stamps')->default(0);

            // czy karta ukończona
            $table->boolean('completed')->default(false);

            $table->timestamps();

            // indeksy
            $table->index('firm_id');
            $table->index('client_id');

            // relacje
            $table->foreign('firm_id')
                ->references('id')
                ->on('firms')
                ->onDelete('cascade');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loyalty_cards');
    }
};
