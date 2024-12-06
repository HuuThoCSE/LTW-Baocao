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
        Schema::create('goat_weights', function (Blueprint $table) {
            $table->id('goat_weight_id');
            $table->unsignedBigInteger('goat_id');
            $table->foreign('goat_id')
                    ->references('goat_id')
                    ->on('farm_goats')
                    ->onDelete('cascade');
            $table->float('weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goat_weighs');
    }
};
