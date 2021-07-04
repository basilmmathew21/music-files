<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TutorEnquiries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone',20);
            $table->enum('gender',['Male','Female','Other'])->nullable();
            $table->date('dob')->nullable();              
            $table->integer('country_id')->unsigned()->index();
            $table->string('state')->nullable();
            $table->string('address')->nullable();            
            $table->string('profile_image')->nullable();
            $table->enum('status', ['new','read','accepted','rejected'])->default('new');
            $table->string('teaching_stream')->nullable();
            $table->string('educational_qualification')->nullable();
            $table->string('teaching_experience')->nullable();
            $table->string('performance_experience')->nullable();
            $table->string('other_details')->nullable();
            $table->date('date_of_enquiry'); 
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
        Schema::drop('tutor_enquiries');
    }
}
