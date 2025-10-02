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
        Schema::create('milk_handling_loss', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('buffalo_milk', 8, 2);
            $table->decimal('cow_milk', 8, 2);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_handling_loss');
    }
};
