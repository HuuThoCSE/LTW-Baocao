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
        Schema::create('type_foods', function (Blueprint $table) {
            $table->id('type_food_id'); // ID của loại thức ăn
            $table->string('type_food_code', 8)->unique(); // Mã loại thức ăn (unique)
            $table->string('type_food_name_vn', 250); // Tên loại thức ăn tiếng Việt
            $table->string('type_food_name_el', 250); // Tên loại thức ăn bằng ngôn ngữ khác
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_foods');
    }
};
