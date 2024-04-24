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
        Schema::create('clients', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('dept_id');
             $table->foreign('dept_id')->references('id')->on('depts');
             $table->string('client_name');
             $table->text('client_ref')->nullable();
             $table->text('client_info')->nullable();
             $table->string('email')->unique();
             $table->string('phone')->unique();
             $table->string('address');
             $table->text('service_info');
             $table->float('total_amount');
             $table->text('discount_info');
             $table->float('discount_amount')->default(0);
             $table->float('payment_amount');
             $table->date('created_date')->nullable();
             $table->date('expired_date')->nullable();
             $table->integer('subcribe'); 
             $table->integer('payment_duration'); 
             $table->text('domain_info')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
