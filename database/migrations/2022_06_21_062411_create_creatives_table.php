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
        Schema::create('creatives', function (Blueprint $table) {
            $table->increments('id')->index()->unique()->comment('Auto_increment');
            $table->string('name',191)->nullable();
            $table->string('creative')->nullable();
            $table->integer('festival_id')->unsigned()->nullable()->comment('id from festival tabel');
            $table->timestamps();



            $table->foreign('festival_id')->on('festivals')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creatives');
    }
};
