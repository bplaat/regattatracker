<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventClassFleetBoatUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_class_fleet_boat_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_class_fleet_boat_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->unique(['event_class_fleet_boat_id', 'user_id'], 'event_class_fleet_boat_user_fleet_boat_id_user_id_unique'); // Must be renamed because to long otherwise

            $table->foreign('event_class_fleet_boat_id')
                ->references('id')
                ->on('event_class_fleet_boat')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('event_class_fleet_boat_user');
    }
}
