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
        Schema::create('milk_production', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('product_name');
            $table->decimal('buffalo_milk_for_kims', 8, 2)->nullable();
            $table->decimal('cow_milk_for_kims', 8, 2)->nullable();
            $table->decimal('buffalo_milk_other_products', 8, 2)->nullable();
            $table->decimal('total_buffalo_milk', 8, 2)->nullable();
            $table->decimal('total_cow_milk', 8, 2)->nullable();
            $table->decimal('total_product_milk', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_production');
    }
};
