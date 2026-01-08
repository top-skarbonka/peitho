<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('firms', function (Blueprint $table) {

            // ILOŚĆ NAKLEJEK
            if (!Schema::hasColumn('firms', 'stamps_required')) {
                $table->unsignedTinyInteger('stamps_required')
                    ->default(10)
                    ->after('program_id');
            }

            // SZABLON KARTY (JUŻ JEST → NIE DODAJEMY DRUGI RAZ)
            if (!Schema::hasColumn('firms', 'card_template')) {
                $table->string('card_template')
                    ->default('classic')
                    ->after('stamps_required');
            }

            // SOCIAL MEDIA
            if (!Schema::hasColumn('firms', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('card_template');
            }

            if (!Schema::hasColumn('firms', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('facebook_url');
            }

            if (!Schema::hasColumn('firms', 'google_review_url')) {
                $table->string('google_review_url')->nullable()->after('instagram_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            // celowo nie cofamy – to konfiguracja biznesowa
        });
    }
};
