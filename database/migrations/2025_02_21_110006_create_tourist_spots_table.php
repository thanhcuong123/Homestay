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
        // Tạo bảng nếu chưa có
        Schema::create('tourist_spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('icon')->nullable();

            $table->timestamps();
        });

        // Thêm cột icon sau khi bảng đã được tạo

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa cột icon trước

    }
};
