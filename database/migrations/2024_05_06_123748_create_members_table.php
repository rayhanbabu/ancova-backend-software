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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dept_id');
            $table->foreign('dept_id')->references('id')->on('depts');
            $table->string('name');
            $table->string('designation');
            $table->string('category');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('web_link')->nullable();
            $table->string('date1')->nullable();
            $table->string('date2')->nullable();
            $table->string('image')->nullable();
            $table->string('others')->nullable();
            $table->text('text')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
