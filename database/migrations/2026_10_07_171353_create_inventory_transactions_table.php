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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('from_location_id')->nullable()->constrained('inventory_locations')->nullOnDelete();
            $table->foreignId('to_location_id')->nullable()->constrained('inventory_locations')->nullOnDelete();
            $table->decimal('quantity', 15, 3);
            $table->enum('type', [
                'opening_balance',
                'purchase_receipt',
                'production_output',
                'production_consumption',
                'sale',
                'transfer_out',
                'transfer_in',
                'return_in',
                'return_out',
                'adjustment_increase',
                'adjustment_decrease',
                'damage',
                'scrap',
            ]);
            $table->nullableMorphs('reference');
            $table->foreignId('performed_by')->constrained('users');
            $table->timestamp('occurred_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'occurred_at']);
            $table->index('from_location_id');
            $table->index('to_location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
