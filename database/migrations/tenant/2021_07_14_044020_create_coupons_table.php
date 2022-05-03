<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // The voucher code
            $table->string('name', 50); // The human readable voucher code name
            $table->text('description')->nullable(); // The description of the voucher - Not necessary 
            $table->integer('uses')->unsigned()->nullable(); // The number of uses currently
            $table->integer('max_uses')->unsigned()->nullable(); // The max uses this voucher has
            $table->integer('max_uses_user')->unsigned()->nullable(); // How many times a user can use this voucher.
            // $table->tinyInteger('type')->unsigned(); // The type can be: voucher, discount, sale. What ever you want.
            $table->enum('type', ['voucher', 'discount', 'sale'])->default('discount'); // The type can be: voucher, discount, sale. What ever you want.
            $table->integer('discount_amount'); // The amount to discount by (in pennies) in this example.
            $table->boolean('is_fixed')->default(true); // Whether or not the voucher is a percentage or a fixed price. 
            $table->timestamp('starts_at')->nullable(); // When the voucher begins
            $table->timestamp('expires_at')->nullable(); // When the voucher ends

            $table->timestamps();
            // $table->softDeletes(); // We like to horde data.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
