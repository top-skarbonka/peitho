<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            $table->string('card_template')->default('classic')->after('slug');
            $table->string('facebook_url')->nullable()->after('card_template');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('google_url')->nullable()->after('instagram_url');
        });
    }

    public function down(): void
    {
        Schema::table('firms', function (Blueprint $table) {
            $table->dropColumn([
                'card_template',
                'facebook_url',
                'instagram_url',
                'google_url',
            ]);
        });
    }
};
