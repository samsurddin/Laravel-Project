<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_charges', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
              ->constrained()
              // ->onUpdate('cascade')
              ->onDelete('cascade');
            $table->foreignId('charge_id')
              ->constrained()
              // ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->integer('charge_amount');

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
        Schema::dropIfExists('order_charges');
    }
}
