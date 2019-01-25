<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('in');
            $table->integer('out');
            $table->integer('remains');
            $table->boolean('is_debt')->default(false);
            $table->integer('debt')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('galons');
    }
}
