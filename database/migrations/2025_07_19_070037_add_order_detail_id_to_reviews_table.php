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
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Thêm cột order_detail_id sau cột product_id
            $table->unsignedBigInteger('order_detail_id')->nullable()->unique()->after('product_id');

            // Thêm ràng buộc khóa ngoại
            $table->foreign('order_detail_id')
                  ->references('id')
                  ->on('order_details')
                  ->onDelete('cascade'); // Tự động xóa review nếu chi tiết đơn hàng bị xóa
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Xóa khóa ngoại và chỉ mục trước khi xóa cột để tránh lỗi
            $table->dropForeign(['order_detail_id']);
            $table->dropUnique(['order_detail_id']);
            $table->dropColumn('order_detail_id');
        });
    }
};