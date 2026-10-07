<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('from_location_id')->constrained('inventory_locations');
            $table->foreignId('to_location_id')->constrained('inventory_locations');
            $table->decimal('quantity');
            $table->enum('type', ['opening_balance', 'inventory_adjustment', 'sale', 'transfer', 'damage']);
            $table->foreignId('performed_by')->constrained('users');
            $table->timestamp('occurred_at');
            $table->string('notes');
            $table->timestamps();
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
