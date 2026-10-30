<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('sales_order_id')->constrained('sales_orders');
            $table->string('invoice_number')->unique();
            $table->timestamp('issued_at');
            $table->timestamp('due_at')->nullable();
            $table->enum('status', ['issued', 'paid', 'overdue', 'void'])->default('issued');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
