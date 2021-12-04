<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->text('Cep');
            $table->integer('Number')->nullable();
            $table->text('City');
            $table->text('Province');
            $table->text('District');
            $table->text('Street');
            $table->bigInteger('userId')->unsigned();
            $table->timestamps();

            //FK's

            $table->foreign("userId")->references("id")->on("users")->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
