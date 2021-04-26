<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event');
            $table->decimal('latitude_a', 10, 8);
            $table->decimal('longitude_a', 11, 8);
            $table->decimal('latitude_b', 10, 8);
            $table->decimal('longitude_b', 11, 8);

            $table->foreign('event')
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
        Schema::dropIfExists('finishes');
    }
}
