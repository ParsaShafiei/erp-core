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
        Schema::create('production_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('bom_id')->nullable()->constrained('boms')->nullOnDelete();
            $table->foreignId('location_id')->constrained('inventory_locations');
            $table->decimal('planned_quantity', 15, 3);
            $table->decimal('produced_quantity', 15, 3)->default(0);
            $table->enum('status', ['draft', 'planned', 'in_progress', 'completed', 'cancelled'])->default('draft');
            $table->date('planned_date');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_orders');
    }
};
