<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_activities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("activity")->unsigned();
            $table->bigInteger("patient")->unsigned();
            $table->text("title");
            $table->text("color")->nullable('#01a0d5');
            $table->dateTime("date");
            $table->dateTime("end")->nullable(null);
            $table->timestamps();

            //FK

            $table->foreign("patient")->references("id")->on("patients")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign("activity")->references("id")->on("activities")->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_activities');
    }
}
