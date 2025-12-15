<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loyalty_stamps', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('loyalty_card_id');

            // opcjonalna notatka (np. ręczna korekta w przyszłości)
            $table->string('note')->nullable();

            $table->timestamps();

            $table->index('loyalty_card_id');

            $table->foreign('loyalty_card_id')
                ->references('id')
                ->on('loyalty_cards')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loyalty_stamps');
    }
};
