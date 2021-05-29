<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventClassFleetCrewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_class_fleet_crews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_class_fleet_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('event_class_fleet_id')
                ->references('id')
                ->on('event_class_fleets')
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
        Schema::dropIfExists('event_class_fleet_crews');
    }
}
