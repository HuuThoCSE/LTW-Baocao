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
        Schema::create('barn_transfers', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->foreignId('goat_id')
                ->constrained('farm_goats', 'goat_id')
                ->onDelete('cascade');
            // ID chuồng cũ
            $table->unsignedBigInteger('old_barn_id')
                ->constrained('farm_barns', 'barn_id')
                ->onDelete('cascade');
            // ID chuồng mới
            $table->unsignedBigInteger('new_barn_id')
            ->constrained('farm_barns', 'barn_id')
                ->onDelete('cascade');
            // ID người thực hiện chuyển chuồng
            $table->unsignedBigInteger('transferred_by')
                ->constrained('Users', 'user_id')
                ->onDelete('cascade');
            $table->timestamp('transferred_at')->useCurrent(); // Thời gian chuyển
            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('BarnTransfers');
    }
};
