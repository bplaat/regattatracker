<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventClassFleetBoatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_class_fleet_boat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_class_fleet_id');
            $table->unsignedBigInteger('boat_id');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->unique(['event_class_fleet_id', 'boat_id']);

            $table->foreign('event_class_fleet_id')
                ->references('id')
                ->on('event_class_fleets')
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
        Schema::dropIfExists('event_class_fleet_boat');
    }
}
