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
        Schema::create('creams', function (Blueprint $table) {
            $table->id();
            $table->date('date');
    
            // Used Milk
            $table->decimal('used_buffalo_milk', 8, 2)->nullable();
            $table->decimal('used_cow_milk', 8, 2)->nullable();
    
            // Cream Output
            $table->decimal('buffalo_cream_output', 8, 2)->nullable();
            $table->decimal('cow_cream_output', 8, 2)->nullable();
    
            // Wasted Milk
            $table->decimal('wasted_buffalo_milk', 8, 2)->nullable();
            $table->decimal('wasted_cow_milk', 8, 2)->nullable();
    
            // Dispatched Cream
            $table->decimal('dispatched_buffalo_cream', 8, 2)->nullable();
            $table->decimal('dispatched_cow_cream', 8, 2)->nullable();
    
            // Wasted Cream - Ghee Making
            $table->decimal('wasted_buffalo_cream_ghee', 8, 2)->nullable();
            $table->decimal('wasted_cow_cream_ghee', 8, 2)->nullable();
    
            // Wasted Cream - Butter Making
            $table->decimal('wasted_buffalo_cream_butter', 8, 2)->nullable();
            $table->decimal('wasted_cow_cream_butter', 8, 2)->nullable();
    
            // Total Wasted Cream
            $table->decimal('total_wasted_buffalo_cream', 8, 2)->nullable();
            $table->decimal('total_wasted_cow_cream', 8, 2)->nullable();
    
            // Used Cream - Ghee Making
            $table->decimal('used_buffalo_cream_ghee', 8, 2)->nullable();
            $table->decimal('used_cow_cream_ghee', 8, 2)->nullable();
    
            // Used Cream - Butter Making
            $table->decimal('used_buffalo_cream_butter', 8, 2)->nullable();
            $table->decimal('used_cow_cream_butter', 8, 2)->nullable();
    
            // Total Used Cream
            $table->decimal('total_used_buffalo_cream', 8, 2)->nullable();
            $table->decimal('total_used_cow_cream', 8, 2)->nullable();
    
            // Remaining Stock
            $table->decimal('remaining_buffalo_cream', 8, 2)->nullable();
            $table->decimal('remaining_cow_cream', 8, 2)->nullable();
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creams');
    }
};
