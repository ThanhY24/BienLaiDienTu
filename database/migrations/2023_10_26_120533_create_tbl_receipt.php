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
        Schema::create('tbl_receipt', function (Blueprint $table) {
            $table->id();
            $table->string('pattern');
            $table->string('serial');
            $table->string('no')->nullable();
            $table->string('fkey');
            $table->string('customer_name');
            $table->string('customer_id')->nullable();
            $table->string('customer_tax_id')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('publisher');
            $table->string('fee_name');
            $table->string('fee_cost');
            $table->string('quantity');
            $table->string('amount');
            $table->string('vat');
            $table->string('vat_amout');
            $table->string('total');
            $table->string('payment_method');
            $table->string('receipt_status')->nullable();
            $table->string('publish_date');
            $table->string('type');
            $table->string('note')->nullable();
            $table->string('log')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('fee_id')->nullable();;
            $table->foreign('fee_id')
                ->references('id')
                ->on('tbl_fee')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_receipt');
    }
};
