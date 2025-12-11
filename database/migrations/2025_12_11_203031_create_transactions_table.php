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

            // POWIĄZANIA
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('firm_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();

            // DANE TRANSAKCJI
            $table->string('type'); // purchase, manual_add, manual_remove itd.
            $table->decimal('amount', 10, 2)->nullable();
            $table->integer('points');
            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
