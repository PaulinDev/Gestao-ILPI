<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinBrandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccine_brands', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->text('name');
            $table->bigInteger('vaccine')->unsigned();
            $table->timestamps();

            $table->foreign('vaccine')->references('id')->on('vaccines')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccin_brandes');
    }
}
