<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('charges', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('cid', 50);
        //     $table->string('name', 50);
        //     $table->string('description', 500);
        //     $table->enum('type', ['tax', 'shipping', 'promo', 'discount', 'service', 'labor']);
        //     $table->integer('amount');
        //     $table->enum('amount_type', ['percent', 'plus', 'minus', 'multiply', 'devide'])->default('percent');
        //     $table->enum('target', ['item', 'charge', 'subtotal', 'total'])->nullable();
        //     $table->timestamps();
        // });
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->string('cid', 50);
            $table->string('name', 50);
            $table->string('description', 500)->nullable();
            $table->enum('type', ['tax', 'shipping', 'promo', 'discount', 'service', 'labor']);
            $table->integer('amount')->default(0);
            $table->enum('amount_type', ['percent', 'plus', 'minus', 'multiply', 'devide'])->default('percent');
            $table->enum('target', ['item', 'charge', 'subtotal', 'total'])->nullable();
            $table->boolean('default')->default(false);

            // $table->foreignId('order_id')
            //   ->constrained()
            //   // ->onUpdate('cascade')
            //   ->onDelete('cascade');

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
        Schema::dropIfExists('charges');
    }
}
