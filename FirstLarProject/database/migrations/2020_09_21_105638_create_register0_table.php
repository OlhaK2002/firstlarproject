<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegister0Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register0', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Name');
            $table->string('Surname');
            $table->string('Email');
            $table->integer('age');
            $table->timestamps();
        });
        Schema::table('register0', function (Blueprint $table) {
            $table->string('profession');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register0');
    }
}
