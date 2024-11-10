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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('dept_id');
            $table->foreign('dept_id')->references('id')->on('depts');

            $table->unsignedBigInteger('category');
            $table->foreign('category')->references('id')->on('weeks');

             $table->text('product_id')->unique();
             $table->text('link')->nullable();
             $table->text('other')->nullable();
             $table->string('image')->nullable();
             $table->string('image1')->nullable();
             $table->string('image2')->nullable();
      
             $table->text('desc1')->nullable();
             $table->text('desc2')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
