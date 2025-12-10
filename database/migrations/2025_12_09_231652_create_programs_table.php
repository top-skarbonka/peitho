<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Nazwa programu (np. Salon Urody Anna)
            $table->string('subdomain')->unique();     // Subdomena programu (np. anna.peitho.pl)
            $table->string('points_name')->default('punkty'); // Nazwa punktów (punkty, żetony, top points)
            $table->decimal('point_ratio', 8, 2)->default(0.50); // np. 1 zł = 0.50 pkt
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
