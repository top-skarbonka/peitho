<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ustaw domyślny plan = basic (id = 1)
        DB::statement("ALTER TABLE firms ALTER COLUMN plan_id SET DEFAULT 1");

        // Jeśli jakaś firma ma NULL → ustaw basic
        DB::table('firms')
            ->whereNull('plan_id')
            ->update(['plan_id' => 1]);
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE firms ALTER COLUMN plan_id DROP DEFAULT");
    }
};
