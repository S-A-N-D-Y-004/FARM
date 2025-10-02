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
        Schema::create('curd_returns', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('curd_standard_1kg', 8, 2)->nullable();
            $table->decimal('curd_standard_5kg', 8, 2)->nullable();
            $table->decimal('curd_standard_10kg', 8, 2)->nullable();
            $table->decimal('curd_standard_total', 8, 2)->nullable();
            $table->decimal('curd_double_1kg', 8, 2)->nullable();
            $table->decimal('curd_double_5kg', 8, 2)->nullable();
            $table->decimal('curd_double_10kg', 8, 2)->nullable();
            $table->decimal('curd_double_total', 8, 2)->nullable();
            $table->decimal('curd_toned_1kg', 8, 2)->nullable();
            $table->decimal('curd_toned_5kg', 8, 2)->nullable();
            $table->decimal('curd_toned_10kg', 8, 2)->nullable();
            $table->decimal('curd_toned_total', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curd_returns');
    }
};
