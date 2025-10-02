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
        Schema::create('milk_for_customers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('buffalo_milk', 8, 2)->default(0);
            $table->decimal('cow_milk', 8, 2)->default(0);
            $table->decimal('total_buffalo_milk',8,2)->default(0);
            $table->decimal('total_cow_milk',8,2)->default(0);           
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_for_customers');
    }
};
