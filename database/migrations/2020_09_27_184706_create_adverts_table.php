<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->string('email');
            $table->string('phone_no');
            $table->string('source');
            $table->bigInteger('duration');
            $table->integer('rate');
            $table->bigInteger('slots');
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('commision')->nullable();
            $table->bigInteger('paid');
            $table->date('start_date');
            $table->date('finish_date');
            $table->unsignedBigInteger('advert_type_id');
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
        Schema::dropIfExists('adverts');
    }
}
