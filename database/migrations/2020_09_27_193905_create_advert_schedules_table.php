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
            $table->boolean('played')->default(0);
            $table->unsignedBigInteger('advert_id');
            $table->unsignedBigInteger('file_id');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::table('advert_schedules', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('advert_files')->onDelete('cascade');
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
