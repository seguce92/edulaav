<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParallelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parallels', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('code');

            $table->boolean('is_enabled')->default(true);

            $table->unsignedBigInteger('grade_id');
            $table->foreign('grade_id')->references('id')->on('grades');

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
        Schema::dropIfExists('parallels');
    }
}
