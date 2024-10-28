<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_roles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->unsignedBigInteger('user_id'); // ID của người dùng
            $table->tinyInteger('role'); // Trường lưu trữ vai trò (0-3)
            // Tạo khóa ngoại cho trường user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
