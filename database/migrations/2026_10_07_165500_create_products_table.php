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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('category_id')->constrained('product_categories');
            $table->foreignId('unit_id')->constrained('units_of_measurement');
            $table->string('sku', 50)->unique();
            $table->string('barcode', 50)->nullable()->unique();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->enum('product_type', ['finished_good', 'raw_material', 'semi_finished', 'packaging']);
            $table->enum('status', ['active', 'discontinued', 'draft'])->default('draft');
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->decimal('selling_price', 15, 2);
            $table->decimal('cost_price', 15, 2)->nullable();
            $table->integer('minimum_stock_level')->default(0);
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
