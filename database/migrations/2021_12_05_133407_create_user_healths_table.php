<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHealthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_healths', function (Blueprint $table) {
            $table->id();
            $table->text('bloodGroup')->nullable();
            $table->text('healthCenter')->nullable();
            $table->text('doctor')->nullable();
            $table->text('contact')->nullable();
            $table->bigInteger('patient')->unsigned();
            $table->timestamps();

            //FK

            $table->foreign('patient')->references('id')->on('patients')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_healths');
    }
}
