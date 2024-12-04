<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barns', function (Blueprint $table) {
            $table->id('barn_id');
            $table->foreignId('area_id')
                ->constrained('areas', 'area_id')
                ->onDelete('cascade'); // Liên kết đến bảng areas
            $table->string('barn_name', 50); // Tên chuồng trại (VD: Barn A, Barn B)
            $table->string('location', 100)->nullable(); // Vị trí của chuồng trại
            $table->text('description')->nullable(); // Mô tả về chuồng trại
            $table->unsignedInteger('capacity')->default(0); // Sức chứa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barns');
    }
};