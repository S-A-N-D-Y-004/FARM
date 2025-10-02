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
        Schema::table('stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('particuler_id')->after('id');
            $table->foreign('particuler_id')->references('id')->on('particulers')->onDelete('cascade');
    
            $table->unique(['particuler_id', 'date']); // Ensures one stock name per date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeign(['particuler_id']);
            $table->dropUnique(['particuler_id', 'date']);
            $table->dropColumn('particuler_id');
        });
    }
};
