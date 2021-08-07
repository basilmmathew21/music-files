<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegfeeToStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->decimal('regfee',10,2)->after('currency_id')->nullable();
            $table->timestamp('regfee_date')->after('regfee')->nullable(); 
            $table->integer('payment_method_id')->after('regfee_date')->unsigned()->nullable(); 
            $table->enum('payment_status',['pending','paid','failed'])->after('payment_method_id')->default('pending');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
}
