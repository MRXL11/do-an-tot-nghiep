<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up(): void
       {
           Schema::create('notifications', function (Blueprint $table) {
               $table->id();
               $table->foreignId('user_id')->constrained()->onDelete('cascade');
               $table->string('title', 100);
               $table->text('message');
              $table->enum('type', ['system', 'order', 'email', 'push', 'product', 'news', 'promotion', 'other']);//   kiểu thông báo
               $table->boolean('is_read')->default(false);
               $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
               $table->timestamp('created_at')->useCurrent();
           });
       }

       public function down(): void
       {
           Schema::dropIfExists('notifications');
       }
   };