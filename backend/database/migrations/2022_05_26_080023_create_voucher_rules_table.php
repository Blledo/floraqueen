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
        Schema::create('voucher_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->nullable(true);
            $table->double('reduction', 8, 2);
            $table->enum('reduction_type', ['percent', 'fixed'])->default('percent');
            $table->enum('reduction_model', ['product', 'product_unit', 'shipping', 'cart'])->default('cart');
            $table->integer('model_id')->nullable(true);
            $table->integer('min_qty')->default(0);
            $table->integer('priority')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('voucher_id')->references('id')->on('vouchers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_rules');
    }
};
