<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();   // basic / pro / enterprise
            $table->string('name');

            // Limity OTP
            $table->unsignedInteger('otp_daily_limit')->default(30);
            $table->unsignedInteger('otp_ip_10m_limit')->default(20);
            $table->unsignedInteger('otp_phone_60s_lock')->default(60);
            $table->unsignedInteger('otp_verify_5m_limit')->default(5);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
