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
        Schema::create('yogurt_dispatch', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->decimal('one_kg', 10, 2)->default(0);
            $table->decimal('five_kg', 10, 2)->default(0);
            $table->decimal('ten_kg', 10, 2)->default(0);
            $table->decimal('total_kg', 10, 2)->default(0);
            $table->decimal('remaining_one_kg', 10, 2)->default(0);
            $table->decimal('remaining_five_kg', 10, 2)->default(0);
            $table->decimal('remaining_ten_kg', 10, 2)->default(0);
            $table->decimal('remaining_total_kg', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
