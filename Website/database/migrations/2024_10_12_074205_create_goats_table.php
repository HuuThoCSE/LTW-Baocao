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
        Schema::create('goats', function (Blueprint $table) {
            $table->id('goat_id');
            $table->string('goat_name', 100);
            $table->integer('goat_age');
            $table->enum('origin', ['imported', 'born_on_farm']);
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('breed_id');
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('farm_id')->references('farm_id')->on('farms')->onDelete('cascade');
            $table->foreign('breed_id')->references('breed_id')->on('breeds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goats');
    }
};
