<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mega extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('mega', function(Blueprint $table){


        $table->increments('id');
        $table->string('en_name')->nullable();
        $table->string('kr_name')->nullable();
        $table->string('chatroute', 30)->unique()->nullable();
        $table->string('email')->unique()->nullable();
        $table->string('password')->nullable();
        $table->string('role')->nullable();
        $table->string('previous_conn_id')->nullable();
        $table->string('current_conn_id')->nullable();
        $table->text('latestmessage')->nullable();
        $table->string('teacher_name')->nullable();
        $table->integer('teacher_idx')->nullable();
        $table->integer('student_idx')->nullable();
        $table->integer('idx')->nullable();
        $table->string('tutor_id')->nullable();
        $table->string('student_id')->nullable();
        $table->json('my_tutors_id')->nullable();
        $table->json('my_students_id')->nullable();
        $table->string('avatar')->nullable();
        $table->string('passkey')->nullable();


        $table->rememberToken();
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
          Schema::dropIfExists('mega');
    }
}
