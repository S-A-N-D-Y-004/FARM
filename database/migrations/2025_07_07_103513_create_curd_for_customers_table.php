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
        Schema::create('curd_for_customers', function (Blueprint $table) {
             $table->id();
        $table->date('date');
        $table->unsignedBigInteger('customer_id');
        
        $table->decimal('tm_1kg', 8, 2)->nullable();
        $table->decimal('tm_5kg', 8, 2)->nullable();
        $table->decimal('tm_10kg', 8, 2)->nullable();

        $table->decimal('stm_1kg', 8, 2)->nullable();
        $table->decimal('stm_5kg', 8, 2)->nullable();
        $table->decimal('stm_10kg', 8, 2)->nullable();

        $table->decimal('dtm_1kg', 8, 2)->nullable();
        $table->decimal('dtm_5kg', 8, 2)->nullable();
        $table->decimal('dtm_10kg', 8, 2)->nullable();

        $table->timestamps();
        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curd_for_customers');
    }
};
