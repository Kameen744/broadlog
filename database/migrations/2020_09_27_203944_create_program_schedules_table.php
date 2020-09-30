<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_schedules', function (Blueprint $table) {
            $table->id();
            $table->time('time_from');
            $table->time('time_to');
            $table->smallInteger('duration');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('opening_day_id');
            $table->timestamps();
        });

        Schema::table('program_schedules', function (Blueprint $table) {
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_schedules');
    }
}
