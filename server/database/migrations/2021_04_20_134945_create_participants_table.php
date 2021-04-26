<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fleet_id');
            $table->unsignedBigInteger('boat_id');
            $table->timestamps();

            $table->unique(['fleet_id', 'boat_id']);

            $table->foreign('fleet_id')
                ->references('id')
                ->on('fleets')
                ->onDelete('cascade');

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
        Schema::dropIfExists('participants');
    }
}
