<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gift_vouchers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('firm_id')->nullable()->constrained()->onDelete('set null');

            $table->enum('type', ['amount', 'service']); // kwotowy lub usługowy
            $table->decimal('amount', 10, 2)->nullable(); // kwota dla voucherów kwotowych
            $table->string('service_name')->nullable();   // nazwa usługi dla usługowych

            $table->string('qr_code')->unique(); // unikalny kod QR
            $table->enum('status', ['active', 'used', 'expired'])->default('active');

            $table->date('valid_until')->nullable(); // data ważności

            $table->string('recipient_name')->nullable();  // imię klienta
            $table->string('recipient_email')->nullable(); // e-mail do wysyłki PDF

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gift_vouchers');
    }
};
