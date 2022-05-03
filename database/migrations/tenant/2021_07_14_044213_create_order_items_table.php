<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('order_id');
            // $table->unsignedBigInteger('product_id');

            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreignId('order_id')
              ->constrained()
              // ->onUpdate('cascade')
              ->onDelete('cascade');

            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('product_id')
              ->constrained()
              // ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->string('name');
            $table->string('thumb', 255)->nullable();
            $table->float('regular_price');
            $table->float('sale_price')->nullable();
            $table->float('price');
            $table->integer('quantity');
            $table->float('item_total');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
