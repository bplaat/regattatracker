<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventClassFleetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_class_fleets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_class_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('event_class_id')
                ->references('id')
                ->on('event_classes')
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
        Schema::dropIfExists('event_class_fleets');
    }
}
