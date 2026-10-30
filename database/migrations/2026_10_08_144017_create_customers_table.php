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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('type', ['retail', 'wholesale', 'corporate'])->default('retail');
            $table->string('name', 150);
            $table->string('phone', 30)->nullable();
            $table->text('address')->nullable();
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->enum('status', ['active', 'suspended', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
