<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandlordTenantsTable extends Migration
{
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('domain')->unique();
            $table->string('database')->unique();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('plan_id')->default(1)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamp('plan_expire_datetime')
                ->nullable()
                ->default(
                    date(
                        'Y-m-d H:i:s', 
                        strtotime('+30 day', time())
                    )
                );
            $table->timestamps();
        });
    }
}
