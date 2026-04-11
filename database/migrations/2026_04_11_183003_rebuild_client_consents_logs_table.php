<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('client_consents_logs');

        Schema::create('client_consents_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('firm_id');

            $table->string('consent_type');
            $table->boolean('value');

            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->string('source')->nullable();
            $table->text('consent_text')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_consents_logs');
    }
};
