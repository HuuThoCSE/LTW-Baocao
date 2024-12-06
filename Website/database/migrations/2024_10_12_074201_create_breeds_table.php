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
        Schema::create('farm_breeds', function (Blueprint $table) {
            $table->id('breed_id');
            $table->foreignId('farm_id')
                    ->constrained('farms', 'farm_id')
                    ->onDelete('cascade');
            $table->string('breed_name_eng', 100);
            $table->string('breed_name_vie', 100);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breeds');
    }
};
