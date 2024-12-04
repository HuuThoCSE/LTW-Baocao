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
        Schema::create('user_owner_farm', function (Blueprint $table) {
            $table->id(); // Tự động tạo cột BIGINT UNSIGNED AUTO_INCREMENT
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Liên kết với bảng users
            $table->foreignId('farm_id')->constrained('farms', 'farm_id')->onDelete('cascade'); // Liên kết với bảng farms
            $table->enum('role', ['owner', 'manager', 'viewer'])->default('owner'); // Vai trò
            $table->timestamps(); // Tự động tạo created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_owner_farm');
    }
};
