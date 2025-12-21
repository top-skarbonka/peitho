<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {

            // Email klienta (obowiązkowy do panelu klienta)
            if (!Schema::hasColumn('clients', 'email')) {
                $table->string('email')->nullable()->index();
            }

            // Hasło klienta (ustawiane przy pierwszym logowaniu)
            if (!Schema::hasColumn('clients', 'password')) {
                $table->string('password')->nullable();
            }

            // Czy klient ustawił hasło
            if (!Schema::hasColumn('clients', 'password_set')) {
                $table->boolean('password_set')->default(false)->index();
            }

            // Token aktywacyjny (link wysyłany mailem)
            if (!Schema::hasColumn('clients', 'activation_token')) {
                $table->string('activation_token', 64)->nullable()->unique();
            }

            // Data wygaśnięcia tokena
            if (!Schema::hasColumn('clients', 'activation_token_expires_at')) {
                $table->timestamp('activation_token_expires_at')->nullable()->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {

            if (Schema::hasColumn('clients', 'activation_token')) {
                $table->dropUnique(['activation_token']);
            }

            $columns = [
                'email',
                'password',
                'password_set',
                'activation_token',
                'activation_token_expires_at',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('clients', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
