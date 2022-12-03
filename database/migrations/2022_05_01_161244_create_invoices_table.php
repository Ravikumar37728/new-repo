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
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id')->index()->unique()->comment('Auto_increment');
            $table->string('user_id')->nullable();
            $table->string('invoice_no')->nullable();

            $table->string('user_name')->nullable();

            $table->string('user_email')->nullable();

            $table->string('user_phone')->nullable();

            $table->string('user_address')->nullable();

            $table->string('user_country_name')->nullable();
            $table->string('user_state_name')->nullable();
            $table->string('user_city_name')->nullable();
            $table->string('user_pin_code')->nullable();
            $table->string('plan_name')->nullable();
            $table->string('plan_amount')->nullable();
            $table->string('cgst_amount')->nullable();

            $table->string('sgst_amount')->nullable();
            $table->string('discount')->nullable();
            $table->string('total_amount')->nullable();

            $table->string('gst_amount')->nullable();

            

            $table->enum('status', ['0', '1', '2'])->nullable()->default('0')->comment('0 =pending, 1 =complete, 2 =notcomplete');
            
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
        Schema::dropIfExists('invoices');
    }
};
