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
        // Khi chạy migrate, hàm này sẽ được gọi
        // Nó sẽ tìm đến bảng 'product_variants' và xóa đi 2 cột 'color' và 'size'
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['color', 'size']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Khi chạy rollback, hàm này sẽ được gọi
        // Nó sẽ thêm lại 2 cột 'color' và 'size' vào bảng 'product_variants'
        // Vị trí của chúng được đặt sau cột 'product_id' để giống với cấu trúc ban đầu
        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('color', 50)->nullable()->after('product_id');
            $table->string('size', 50)->nullable()->after('color');
        });
    }
};