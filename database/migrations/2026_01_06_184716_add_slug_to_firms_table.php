<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        // 1) Dodaj kolumnę slug tylko jeśli jej nie ma
        if (!Schema::hasColumn('firms', 'slug')) {
            Schema::table('firms', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('id');
            });
        }

        // 2) Uzupełnij puste slug-i (żeby UNIQUE nie wywalił)
        $firms = DB::table('firms')->select('id', 'name', 'slug')->get();
        foreach ($firms as $firm) {
            if (empty($firm->slug)) {
                $base = $firm->name ? Str::slug($firm->name) : 'firma';
                DB::table('firms')
                    ->where('id', $firm->id)
                    ->update(['slug' => $base . '-' . $firm->id]);
            }
        }

        // 3) Dodaj UNIQUE tylko jeśli jeszcze nie ma
        // MySQL: sprawdzamy index w information_schema
        $dbName = DB::getDatabaseName();

        $exists = DB::table('information_schema.statistics')
            ->where('table_schema', $dbName)
            ->where('table_name', 'firms')
            ->where('index_name', 'firms_slug_unique')
            ->exists();

        if (!$exists) {
            Schema::table('firms', function (Blueprint $table) {
                $table->unique('slug');
            });
        }
    }

    public function down(): void
    {
        // zdejmij unique jeśli istnieje
        try {
            Schema::table('firms', function (Blueprint $table) {
                $table->dropUnique('firms_slug_unique');
            });
        } catch (\Throwable $e) {}

        // usuń kolumnę jeśli istnieje
        if (Schema::hasColumn('firms', 'slug')) {
            Schema::table('firms', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
