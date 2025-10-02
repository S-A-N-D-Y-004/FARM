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
        Schema::create('butter', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('used_buffalo_cream', 8, 2)->nullable();
            $table->decimal('used_cow_cream', 8, 2)->nullable();
            $table->decimal('output_buffalo_butter', 8, 2)->nullable();
            $table->decimal('output_cow_butter', 8, 2)->nullable();
            $table->decimal('wastage_buffalo_cream', 8, 2)->nullable();
            $table->decimal('wastage_cow_cream', 8, 2)->nullable();
            $table->decimal('dispatch_buffalo_butter', 8, 2)->nullable();
            $table->decimal('dispatch_cow_butter', 8, 2)->nullable();
            $table->decimal('remaining_buffalo_butter', 8, 2)->nullable();
            $table->decimal('remaining_cow_butter', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('butter');
    }
};
