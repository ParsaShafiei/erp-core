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
        Schema::create('inventory_locations', function (Blueprint $table) {
            $table->id();
            $table->string('locatable_type');
            $table->unsignedBigInteger('locatable_id');
            $table->string('code', 20)->unique();
            $table->string('name', 150);
            $table->enum('type', ['warehouse', 'branch', 'representative_store', 'in_transit', 'virtual']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['locatable_type', 'locatable_id']);
            $table->index(['locatable_type', 'locatable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_locations');
    }
};
