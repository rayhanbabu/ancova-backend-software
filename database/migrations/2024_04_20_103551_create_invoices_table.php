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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dept_id');
            $table->foreign('dept_id')->references('id')->on('depts');

            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->text('service_info');
            $table->float('total_amount');
            $table->text('discount_info');
            $table->float('discount_amount')->default(0);
            $table->float('payment_amount');
            $table->date('invoice_date');
            $table->date('payment_date')->nullable();
            $table->integer('payment_status')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('payment_month')->nullable();
            $table->integer('payment_day')->nullable();
            $table->integer('payment_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
