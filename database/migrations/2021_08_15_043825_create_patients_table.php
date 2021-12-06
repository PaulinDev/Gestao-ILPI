<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('name');
            $table->string('nick');
            $table->string('additional')->nullable();
            $table->dateTime('birthdate');
            $table->dateTime('admission');
            $table->bigInteger('gender')->unsigned();
            $table->bigInteger('civil')->unsigned();
            $table->bigInteger('education')->unsigned();
            $table->bigInteger('occupation')->unsigned();
            $table->bigInteger('country')->unsigned();
            $table->bigInteger('situation')->unsigned();
            $table->timestamps();

            //FK's

            $table->foreign('gender')->references('id')->on('genders')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('civil')->references('id')->on('civils')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('education')->references('id')->on('education')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('occupation')->references('id')->on('occupations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('country')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('situation')->references('id')->on('situations')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
