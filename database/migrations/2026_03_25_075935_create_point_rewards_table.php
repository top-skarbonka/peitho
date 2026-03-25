<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('firm_id');
            $table->integer('points_required');
            $table->integer('reward_value');
            $table->string('label')->nullable();
            $table->timestamps();

            $table->index('firm_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_rewards');
    }
};
