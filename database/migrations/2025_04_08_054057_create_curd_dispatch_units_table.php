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
        Schema::create('curd_dispatch_units', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name'); // Should match curdbatch name for that date
        
            // Dispatched values
            $table->decimal('tonned_milk_1kg')->default(0);
            $table->decimal('tonned_milk_5kg')->default(0);
            $table->decimal('tonned_milk_10kg')->default(0);
        
            $table->decimal('double_tonned_milk_1kg')->default(0);
            $table->decimal('double_tonned_milk_5kg')->default(0);
            $table->decimal('double_tonned_milk_10kg')->default(0);
        
            $table->decimal('standard_tonned_milk_1kg')->default(0);
            $table->decimal('standard_tonned_milk_5kg')->default(0);
            $table->decimal('standard_tonned_milk_10kg')->default(0);
        
            // Remaining stock fields
            $table->decimal('remaining_tonned_milk_1kg')->default(0);
            $table->decimal('remaining_tonned_milk_5kg')->default(0);
            $table->decimal('remaining_tonned_milk_10kg')->default(0);
        
            $table->decimal('remaining_double_tonned_milk_1kg')->default(0);
            $table->decimal('remaining_double_tonned_milk_5kg')->default(0);
            $table->decimal('remaining_double_tonned_milk_10kg')->default(0);
        
            $table->decimal('remaining_standard_tonned_milk_1kg')->default(0);
            $table->decimal('remaining_standard_tonned_milk_5kg')->default(0);
            $table->decimal('remaining_standard_tonned_milk_10kg')->default(0);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curd_dispatch_units');
    }
};
