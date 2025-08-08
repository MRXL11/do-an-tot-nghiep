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
        Schema::create('product_variant_attributes', function (Blueprint $table) {
            // Khóa ngoại, liên kết tới ID của bảng 'product_variants'
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade');

            // Khóa ngoại, liên kết tới ID của bảng 'attribute_values'
            $table->foreignId('attribute_value_id')->constrained('attribute_values')->onDelete('cascade');

            // Thiết lập khóa chính phức hợp: Mỗi cặp (biến thể, giá trị thuộc tính) là duy nhất
            $table->primary(['product_variant_id', 'attribute_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_attributes');
    }
};