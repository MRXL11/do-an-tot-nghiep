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
        Schema::create('attribute_values', function (Blueprint $table) {
            // Cột ID, tự động tăng và là khóa chính
            $table->id();

            // Tạo cột khóa ngoại 'attribute_id'
            // constrained('attributes') -> liên kết với bảng 'attributes'
            // onDelete('cascade') -> nếu xóa thuộc tính cha, các giá trị con cũng bị xóa
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade');

            // Cột lưu giá trị thuộc tính, ví dụ: 'Đỏ', 'S', 'M'
            $table->string('value', 100);

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
        Schema::dropIfExists('attribute_values');
    }
};