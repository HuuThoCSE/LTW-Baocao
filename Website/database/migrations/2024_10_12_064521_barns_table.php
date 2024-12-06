<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farm_barns', function (Blueprint $table) {
            $table->id('barn_id');
            $table->foreignId('area_id')
                ->constrained('farm_areas', 'area_id')
                ->onDelete('cascade'); // Liên kết đến bảng areas
            $table->string('barn_name', 50); // Tên chuồng trại (VD: BarnModel A, BarnModel B)
            $table->foreignId('farm_id')
                ->constrained('farms', 'farm_id')
                ->onDelete('cascade');
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
