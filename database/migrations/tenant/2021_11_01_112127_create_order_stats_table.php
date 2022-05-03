<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_stats', function (Blueprint $table) {
            $table->id();
            $table->integer('count')->default(0);

            // $table->foreignId('order_id')
            //   ->constrained()
            //   // ->onUpdate('cascade')
            //   ->onDelete('cascade');

            $table->foreignId('user_id')->nullable()
              ->constrained()
              // ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->foreignId('category_id')->nullable()
              ->constrained()
              // ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->foreignId('status_id')->nullable()
              ->constrained('order_statuses')
              // ->onUpdate('cascade')
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
        Schema::dropIfExists('order_stats');
    }
}
