<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramPresentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_presenters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('presenter_id');
            $table->timestamps();
        });

        Schema::table('program_presenters', function(Blueprint $table) {
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('presenter_id')->references('id')->on('presenters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_presenters');
    }
}
