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
        Schema::create('closing_stock', function (Blueprint $table) {
            $table->date('date');
            $table->decimal('raw_buffalo_milk', 8, 2)->nullable();
            $table->decimal('raw_cow_milk', 8, 2)->nullable();
            $table->decimal('return_buffalo_milk', 8, 2)->nullable();
            $table->decimal('return_cow_milk', 8, 2)->nullable();
            $table->decimal('total_buffalo_milk', 8, 2)->nullable();
            $table->decimal('total_cow_milk', 8, 2)->nullable();
            $table->decimal('dispatched_buffalo_milk', 8, 2)->nullable();
            $table->decimal('dispatched_cow_milk', 8, 2)->nullable();
            $table->decimal('used_buffalo_milk', 8, 2)->nullable();
            $table->decimal('used_cow_milk', 8, 2)->nullable();
            $table->decimal('remaining_buffalo_milk', 8, 2)->nullable();
            $table->decimal('remaining_cow_milk', 8, 2)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closing_stock');
    }
};
