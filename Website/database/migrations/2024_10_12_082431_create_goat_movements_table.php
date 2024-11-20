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
        Schema::create('goat_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goat_id');
            $table->unsignedBigInteger('farm_id');
            $table->timestamp('moved_at')->nullable(); // Ngày giờ dê di chuyển
            $table->timestamps();
        
            // Khóa ngoại
            $table->foreign('goat_id')->references('goat_id')->on('goats')->onDelete('cascade ');
            $table->foreign('farm_id')->references('farm_id')->on('farms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goat_movements');
    }
};
