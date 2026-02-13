<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consent_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('loyalty_card_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('firm_id');

            $table->tinyInteger('old_value')->nullable();
            $table->tinyInteger('new_value')->nullable();

            $table->string('ip_address', 64)->nullable();
            $table->text('user_agent')->nullable();

            $table->string('source', 32)->default('client_wallet');

            $table->timestamps();

            $table->index(['client_id', 'firm_id']);
            $table->index(['loyalty_card_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consent_logs');
    }
};
