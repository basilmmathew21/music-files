<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone',20)->after('email');
            $table->integer('user_type_id')->after('phone')->unsigned()->index();
            $table->enum('gender',['Male','Female','Other'])->after('user_type_id')->nullable();
            $table->date('dob')->after('gender')->nullable();              
            $table->integer('country_id')->after('dob')->unsigned()->index();
            $table->string('state')->after('country_id')->nullable();
            $table->string('address')->after('state')->nullable();            
            $table->string('profile_image')->after('address')->nullable();
            $table->boolean('is_active')->after('remember_token')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'user_type_id', 'gender','dob', 'country_id', 'state', 'address','profile_image', 'is_active']);
        });
    }
}
