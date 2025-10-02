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
        Schema::create('curdbatch', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name');
            $table->decimal('whole_buffalo_milk', 8, 2)->default(0);
            $table->decimal('skimmed_buffalo_milk', 8, 2)->default(0);
            $table->decimal('total_buffalo_milk', 8, 2)->default(0);
            $table->decimal('total_cow_milk', 8, 2)->default(0);
            $table->decimal('skimmed_cow_milk', 8, 2)->default(0);
            $table->string('skimmed_milk_provider')->nullable();
            $table->integer('one_kg')->default(0);
            $table->integer('five_kg')->default(0);
            $table->integer('ten_kg')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curdbatch');
    }
};
