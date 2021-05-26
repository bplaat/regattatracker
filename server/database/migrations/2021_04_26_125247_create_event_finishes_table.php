<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventFinishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_finishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->decimal('latitude_a', 10, 8);
            $table->decimal('longitude_a', 11, 8);
            $table->decimal('latitude_b', 10, 8);
            $table->decimal('longitude_b', 11, 8);

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_finishes');
    }
}
