<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tutors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('teaching_stream')->nullable();
            $table->string('educational_qualification')->nullable();
            $table->string('teaching_experience')->nullable();
            $table->string('performance_experience')->nullable();
            $table->string('other_details')->nullable();
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
        Schema::drop('tutors');
    }
}
