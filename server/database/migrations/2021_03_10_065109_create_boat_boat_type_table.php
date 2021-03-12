<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoatBoatTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boat_boat_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boat_id');
            $table->unsignedBigInteger('boat_type_id');
            $table->timestamps();

            $table->unique([ 'boat_id', 'boat_type_id' ]);

            $table->foreign('boat_id')
                ->references('id')
                ->on('boats')
                ->onDelete('cascade');

            $table->foreign('boat_type_id')
                ->references('id')
                ->on('boat_types')
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
        Schema::dropIfExists('boat_boat_type');
    }
}
