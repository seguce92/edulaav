<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();

            $table->string('ci', 15)->unique();
            $table->string('rude', 20)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('adress', 150)->nullable();
            $table->date('birthday');
            $table->decimal('size', 2, 2)->nullable();
            $table->string('medic', 50)->nullable();
            $table->string('blood_type', 4)->default('ORH+');
            $table->string('site', 150)->nullable();
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->string('procedent', 150)->nullable();
            
            $table->string('father_name', 150)->nullable();
            $table->string('mother_name', 150)->nullable();
            $table->string('father_occupation', 100)->nullable();
            $table->string('mother_occupation', 100)->nullable();
            $table->string('father_email', 100)->nullable();
            $table->string('mother_email', 100)->nullable();
            $table->string('father_phone', 30)->nullable();
            $table->string('mother_phone', 30)->nullable();
            $table->string('tutor_phone', 30)->nullable();
            $table->string('tutor_email', 100)->nullable();

            $table->date('work_from')->nullable();

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
        Schema::dropIfExists('information');
    }
}
