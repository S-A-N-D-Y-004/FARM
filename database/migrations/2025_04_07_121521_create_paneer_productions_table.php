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
        Schema::create('paneer_productions', function (Blueprint $table) {
            $table->id();
    $table->date('date');
    
    // Milk input
    $table->decimal('buffalo_milk', 8, 2)->default(0);
    $table->decimal('cow_milk', 8, 2)->default(0);
    
    // Paneer output
    $table->decimal('output_buffalo_paneer', 8, 2)->default(0);
    $table->decimal('output_cow_paneer', 8, 2)->default(0);
    $table->decimal('output_mixed_paneer', 8, 2)->default(0);

    // Wastage
    $table->decimal('buffalo_milk_wastage', 8, 2)->default(0);
    $table->decimal('cow_milk_wastage', 8, 2)->default(0);

    // Dispatch
    $table->decimal('dispatch_buffalo_paneer', 8, 2)->default(0);
    $table->decimal('dispatch_cow_paneer', 8, 2)->default(0);
    $table->decimal('dispatch_mixed_paneer', 8, 2)->default(0);

    // Remaining stock
    $table->decimal('remaining_buffalo_paneer', 8, 2)->default(0);
    $table->decimal('remaining_cow_paneer', 8, 2)->default(0);
    $table->decimal('remaining_mixed_paneer', 8, 2)->default(0);

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paneer_productions');
    }
};
