<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->year('year');
            $table->boolean('is_enabled')->default(true);

            $table->unsignedBigInteger('grade_id');
            $table->foreign('grade_id')->references('id')->on('grades');

            $table->unsignedBigInteger('parallel_id');
            $table->foreign('parallel_id')->references('id')->on('parallels');

            $table->unsignedBigInteger('adviser_id')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('rooms');
    }
}
