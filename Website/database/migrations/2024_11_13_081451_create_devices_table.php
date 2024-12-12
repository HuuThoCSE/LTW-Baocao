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
        Schema::create('farm_devices', function (Blueprint $table) {
            $table->id('device_id');
            $table->foreignId('type_device_id')
                  ->constrained('type_devices', 'type_device_id') // Chỉ định bảng và cột khóa chính cụ thể
                  ->onDelete('cascade');
            $table->string('device_name', 50);
            $table->string('device_token')->nullable();
            $table->string('status', 20)
                    ->default('Active');
            $table->foreignId('farm_id')
                    ->nullable()
                    ->constrained('farms', 'farm_id')
                    ->onDelete('no action'); // Liên kết đến farm, có thể null nếu thiết bị ở cấp thấp hơn
            $table->foreignId('zone_id')
                    ->nullable()
                    ->constrained('zones', 'zone_id')
                    ->onDelete('cascade'); // Quản lý thiết bị theo khu vực
            $table->foreignId('barn_id')
                    ->nullable()
                    ->constrained('farm_barns', 'barn_id')
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
