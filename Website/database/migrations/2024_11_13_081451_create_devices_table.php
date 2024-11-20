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
        Schema::create('devices', function (Blueprint $table) {
            $table->id('device_id');
            $table->foreignId('device_type_id')
                  ->constrained('device_types', 'device_type_id') // Chỉ định bảng và cột khóa chính cụ thể
                  ->onDelete('cascade');
            $table->string('device_name', 50);
            $table->string('status', 20)->default('Active');
            $table->foreignId('farm_id')->nullable()
                    ->constrained('farms', 'farm_id')
                    ->onDelete('cascade'); // Liên kết đến farm, có thể null nếu thiết bị ở cấp thấp hơn
            $table->foreignId('zone_id')
                    ->nullable()->constrained('zones', 'zone_id')
                    ->onDelete('cascade'); // Quản lý thiết bị theo khu vực
            $table->foreignId('barn_id')
                    ->nullable()
                    ->constrained('barns', 'barn_id')
                    ->onDelete('cascade'); // Quản lý thiết bị theo chuồng trại
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};