<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id')->index()->unique()->comment('Auto_increment');
            $table->string('user_id')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('couuntry')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_price')->nullable();
            $table->string('cgst')->nullable();

            $table->string('sgst')->nullable();
            $table->string('discount')->nullable();
            $table->string('amount')->nullable();

            $table->string('gst')->nullable();

            $table->enum('payment_status', ['0', '1', '2'])->nullable()->default('0')->comment('0 =pending, 1 =complete, 2 =notcomplete');

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
        Schema::dropIfExists('subscriptions');
    }
};
