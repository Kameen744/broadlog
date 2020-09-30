<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('play_date');
            $table->time('play_time');
            $table->unsignedBigInteger('advert_id');
            $table->timestamps();
        });

        Schema::table('advert_schedules', function (Blueprint $table) {
            $table->foreign('advert_id')->references('id')->on('adverts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advert_schedules');
    }
}
