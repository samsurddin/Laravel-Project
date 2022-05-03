<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postcodes', function (Blueprint $table) {
            $table->id();
            $table->string('postCode', 10)->unique();
            $table->string('upazila', 50)->nullable();
            $table->string('postOffice', 50)->nullable();
            $table->foreignId('division_id')->nullable()
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('set null');
            $table->foreignId('district_id')->nullable()
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('set null');
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
        Schema::dropIfExists('postcodes');
    }
}
