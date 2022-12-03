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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->index()->unique()->comment('Auto_increment');
            $table->string('name',191)->nullable();
            $table->string('short_desc',191)->nullable();
            $table->text('desc')->nullable();
            $table->string('product_image')->comment('jpg,png,jpeg')->nullable();
            $table->string('product_video')->comment('trailer video')->nullable();
            $table->integer('price');
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
        Schema::dropIfExists('products');
    }
};
