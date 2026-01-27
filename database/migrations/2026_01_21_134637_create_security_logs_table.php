<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();

            // kto wykonał akcję
            $table->string('actor_type'); // admin / system
            $table->unsignedBigInteger('actor_id')->nullable();

            // jaka akcja
            $table->string('action'); // export_consents, login_failed itp.
            $table->string('target')->nullable(); // np. firm_id=16

            // skąd
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            // kiedy
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};
