<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('folder')->nullable();
            $table->string('name')->nullable();
            $table->string('extension')->nullable();
            $table->string('alt')->nullable();
            $table->string('caption')->nullable();
            $table->text('description')->nullable();
            // $table->boolean('is_featured')->default(false);
            // $table->enum('use_as', ['featured', 'alt_featured', 'gallery', 'slider'])->default('active');
            // $table->bigInteger('imageable_id');
            // $table->string('imageable_type ');
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
        Schema::dropIfExists('images');
    }
}
