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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id")->unsigned()->nullable()->index();
            $table->bigInteger("product_id")->unsigned()->nullable()->index();
            $table->double("price")->nullable();
            $table->bigInteger("quantity")->nullable();
            $table->double("amount")->nullable();
            $table->timestamps();

            $table->foreign("order_id")->references('id')->on('orders')->onDelete("CASCADE");
            $table->foreign("product_id")->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
