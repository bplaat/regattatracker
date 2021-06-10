<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoatGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boat_guests', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('insertion')->nullable();
            $table->string('lastname');
            $table->unsignedTinyInteger('gender');
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('boat_id');
            $table->timestamps();


            $table->foreign('boat_id')
                ->references('id')
                ->on('boats')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boat_guests');
    }
}
