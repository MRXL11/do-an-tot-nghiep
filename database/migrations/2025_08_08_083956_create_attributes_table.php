<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            // Cột ID, tự động tăng và là khóa chính
            $table->id();

            // Cột lưu tên thuộc tính, ví dụ: 'Màu sắc', 'Kích thước'
            $table->string('name', 100);

            // Tự động tạo 2 cột created_at và updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
};