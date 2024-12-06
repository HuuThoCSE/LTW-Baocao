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
        Schema::create('farm_areas', function (Blueprint $table) {
            $table->id('area_id');
            $table->foreignId('zone_id')
                ->constrained('zones', 'zone_id')
                ->onDelete('cascade');
            $table->foreignId('farm_id')
                ->constrained('farms', 'farm_id')
                ->onDelete('cascade');
            $table->string('area_name');  // Tên khu vực (Vinh Long, Tiền Giang, v.v.)
            $table->text('description')->nullable();  // Mô tả khu vực (tùy chọn)
            $table->timestamps();  // Các trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
}
?>
