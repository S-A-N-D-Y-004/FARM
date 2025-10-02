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
        Schema::create('milk_storage', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedInteger('vendor_id'); // Match with vendors.id type
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

            $table->decimal('litres_am_buffalo', 8, 2)->nullable();
            $table->decimal('litres_am_cow', 8, 2)->nullable();
            $table->decimal('litres_pm_buffalo', 8, 2)->nullable();
            $table->decimal('litres_pm_cow', 8, 2)->nullable();
            $table->decimal('fat_am_buffalo', 5, 2)->nullable();
            $table->decimal('fat_am_cow', 5, 2)->nullable();
            $table->decimal('fat_pm_buffalo', 5, 2)->nullable();
            $table->decimal('fat_pm_cow', 5, 2)->nullable();
            $table->decimal('snf_am_buffalo', 5, 2)->nullable();
            $table->decimal('snf_am_cow', 5, 2)->nullable();
            $table->decimal('snf_pm_buffalo', 5, 2)->nullable();
            $table->decimal('snf_pm_cow', 5, 2)->nullable();
            $table->decimal('water_am_buffalo', 5, 2)->nullable();
            $table->decimal('water_am_cow', 5, 2)->nullable();
            $table->decimal('water_pm_buffalo', 5, 2)->nullable();
            $table->decimal('water_pm_cow', 5, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->decimal('total_buffalo', 8, 2)->nullable();
            $table->decimal('total_cow', 8, 2
            
            )->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_storage');
    }
};
