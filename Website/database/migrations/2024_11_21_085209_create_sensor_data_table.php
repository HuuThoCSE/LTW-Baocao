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
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id('sensor_data_id'); // ID tự động tăng, khóa chính
            $table->string('sensor_id');
            $table->decimal('temperature', 5, 2);
            $table->decimal('humidity', 5, 2);
            $table->timestamp('recorded_at')->useCurrent();
            $table->foreignId('farm_id')
                ->nullable()
                ->constrained('farms', 'farm_id')
                ->onDelete('cascade');
            $table->float('value'); // Giá trị đo từ cảm biến
            $table->timestamp('timestamp')->default(DB::raw('CURRENT_TIMESTAMP')); // Thời gian lấy mẫu
            $table->text('remarks')->nullable(); // Ghi chú bổ sung
            $table->timestamps(); // Tự động thêm created_at và updated_at

            $table->index('sensor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
