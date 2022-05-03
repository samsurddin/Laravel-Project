<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_answers', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');

            $table->foreignId('product_id')
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('cascade')->nullable();

            $table->foreignId('user_id')
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('cascade')->nullable();
            
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
        Schema::dropIfExists('question_answers');
    }
}
