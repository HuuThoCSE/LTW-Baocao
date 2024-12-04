<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id('zone_id');
            $table->foreignId('farm_id')
                    ->constrained('farms', 'farm_id')
                    ->onDelete('cascade'); // Liên kết đến bảng farms
            $table->string('zone_name', 50); // Tên của khu vực (VD: Livestock Zone, Feed Storage Zone)
            $table->text('description')->nullable(); // Mô tả khu vực
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};