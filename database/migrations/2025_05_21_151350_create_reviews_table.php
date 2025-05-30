<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up(): void
       {
           Schema::create('reviews', function (Blueprint $table) {
               $table->id();
               $table->foreignId('user_id')->constrained()->onDelete('cascade');
               $table->foreignId('product_id')->constrained()->onDelete('cascade');
               $table->tinyInteger('rating')->unsigned()->check('rating BETWEEN 1 AND 5');
               $table->text('comment')->nullable();
               $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
               $table->timestamps();
           });
       }

       public function down(): void
       {
           Schema::dropIfExists('reviews');
       }
   };