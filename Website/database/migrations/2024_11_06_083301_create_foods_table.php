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
        Schema::create('foods', function (Blueprint $table) {
            $table->id('food_id'); // ID của thức ăn
            $table->string('food_code', 8); // Mã thức ăn
            $table->string('food_name_vn', 250); // Tên thức ăn tiếng Việt
            $table->string('food_name_el', 250); // Tên thức ăn bằng ngôn ngữ khác
            $table->foreignId('farm_id')
                ->nullable()
                ->constrained('farms', 'farm_id')
                ->onDelete('cascade');
            $table->string('expiry_date', 250); // Ngày hết hạn
            $table->foreignId('type_food_id') // Khóa ngoại liên kết đến food_types
                ->constrained('type_foods', 'type_food_id') // Chỉ định bảng và cột khóa chính
                ->onDelete('cascade'); // Khi xóa loại thức ăn, thức ăn liên quan cũng bị xóa
            $table->timestamps(); // created_at và updated_at
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
