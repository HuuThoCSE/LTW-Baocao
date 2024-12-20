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
        Schema::create('farm_goats', function (Blueprint $table) {
            $table->id('goat_id');
            $table->string('goat_name', 100);
            $table->integer('goat_age');
            $table->string('breed_color', 100)->nullable();
            $table->enum('origin', ['imported', 'born_on_farm']);
            $table->timestamps();

            // Khóa ngoại
            $table->foreignId('farm_id')
                ->constrained('farms', 'farm_id')
                ->onDelete('cascade');

            $table->foreignId('breed_id')
                ->constrained('farm_breeds', 'breed_id')
                ->onDelete('cascade');
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
