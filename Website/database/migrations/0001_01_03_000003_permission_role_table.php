<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')  // Khóa ngoại role_id
                ->constrained('farm_roles', 'role_id')  // Đảm bảo tên bảng là farm_roles
                ->onDelete('cascade');
            $table->foreignId('permission_id')  // Khóa ngoại permission_id
                ->constrained('permissions', 'permission_id')  // Đảm bảo tên bảng là permissions
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_role');
    }
};
