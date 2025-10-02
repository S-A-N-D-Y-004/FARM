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
        Schema::create('cultures', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('tm', 8, 2)->nullable();
            $table->decimal('stm', 8, 2)->nullable();
            $table->decimal('dtm', 8, 2)->nullable();
            $table->decimal('total_culture', 8, 2)->nullable();
            $table->decimal('added_culture', 8, 2)->nullable();
            $table->decimal('remaining_stock', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultures');
    }
};
