<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->nullable()
              ->constrained()
              // ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->dateTime('date')->useCurrent();
            $table->string('note')->nullable();
            $table->boolean('by_user')->default(false);
            $table->boolean('public')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('order_notes');
    }
}
