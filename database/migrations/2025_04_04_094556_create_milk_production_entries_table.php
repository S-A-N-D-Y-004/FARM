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
        Schema::create('milk_production_entries', function (Blueprint $table) {
            $table->id();
            // Explicitly specify the foreign table name 'milk_production'
            $table->foreignId('milk_production_id')
                ->constrained('milk_production')
                ->onDelete('cascade');

            // 'products' is likely correct in plural form
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            $table->decimal('quantity', 8, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_production_entries');
    }
};
