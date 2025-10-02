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
        Schema::create('stock_in_units', function (Blueprint $table) {
            $table->id();
        $table->date('date')->unique();

        $table->integer('mixed_paneer')->default(0);
        $table->integer('buffalo_paneer')->default(0);
        $table->integer('cow_paneer')->default(0);
        $table->integer('total_paneer')->default(0);

        $table->integer('buffalo_cream')->default(0);
        $table->integer('cow_cream')->default(0);
        $table->integer('total_cream')->default(0);

        $table->integer('buffalo_ghee')->default(0);
        $table->integer('cow_ghee')->default(0);
        $table->integer('total_ghee')->default(0);

        $table->integer('buffalo_butter')->default(0);
        $table->integer('cow_butter')->default(0);
        $table->integer('total_butter')->default(0);

        $table->integer('stm_1kg')->default(0);
        $table->integer('stm_5kg')->default(0);
        $table->integer('stm_10kg')->default(0);
        $table->integer('total_stm')->default(0);

        $table->integer('tm_1kg')->default(0);
        $table->integer('tm_5kg')->default(0);
        $table->integer('tm_10kg')->default(0);
        $table->integer('total_tm')->default(0);

        $table->integer('dtm_1kg')->default(0);
        $table->integer('dtm_5kg')->default(0);
        $table->integer('dtm_10kg')->default(0);
        $table->integer('total_dtm')->default(0);

        $table->integer('buffalo_milk')->default(0);
        $table->integer('cow_milk')->default(0);
        $table->integer('total_milk')->default(0);

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in_units');
    }
};
