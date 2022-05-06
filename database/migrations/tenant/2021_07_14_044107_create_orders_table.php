<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_number')->unique();
            // $table->unsignedBigInteger('user_id');
            // $table->enum('status', ['pending','processing','completed','decline'])->default('pending');
            $table->float('grand_total');
            $table->float('sub_total');
            $table->json('charges')->nullable();
            $table->float('total_charges')->default(0);
            $table->integer('item_count');
            $table->boolean('is_paid')->default(false);
            $table->enum('payment_method', ['cash_on_delivery', 'ssl_commerze', 'surjo_pay','aamar_pay', 'bkash', 'nagad', 'rocket', 'bank_cheque', 'bank_diposit', 'paypal'])->default('cash_on_delivery');
            $table->string('offer')->nullable();
            $table->string('status')->nullable();

            $table->string('shipping_fullname');
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->string('shipping_zipcode');
            $table->string('shipping_mobile');
            $table->string('shipping_email');
            $table->string('shipping_note')->nullable();

            $table->string('shipping_alt_contact')->nullable();
            $table->string('shipping_alt_mobile')->nullable();

            $table->string('billing_fullname');
            $table->string('billing_address');
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_zipcode');
            $table->string('billing_mobile');
            $table->string('billing_email');

            $table->string('ip_address')->nullable();
            $table->string('mac')->nullable();
            $table->string('tracking_number')->nullable();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreignId('coupon_id')->nullable()
              ->constrained()
              // ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->foreignId('status_id')->nullable()
              ->constrained('order_statuses')
              // ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->foreignId('user_id')
              ->constrained()
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
        Schema::dropIfExists('orders');
    }
}
