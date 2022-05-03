<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->mediumText('description')->nullable();
            $table->float('regular_price');
            $table->float('sale_price')->nullable();
            $table->string('featured_img')->nullable();
            $table->string('sku', 50)->nullable();
            $table->enum('stock_available', ['yes', 'not'])->default('yes');
            $table->integer('stock_quantity')->nullable();

            $table->string('what_is_q')->nullable();
            $table->text('what_is_a')->nullable();

            // $table->unsignedBigInteger('featured_img')->nullable();
            // $table->foreign('featured_img')->references('id')->on('images')->onDelete('set null');

            // $table->foreignId('image_id')
            //   ->constrained('images')
            //   ->onUpdate('cascade')
            //   ->onDelete('set null')->nullable();

            $table->foreignId('shop_id')->nullable()
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->foreignId('brand_id')->nullable()
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('cascade');

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
        Schema::dropIfExists('products');
    }
}
