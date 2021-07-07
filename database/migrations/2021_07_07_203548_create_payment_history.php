<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('student_user_id')->unsigned();
            $table->integer('tutor_user_id')->unsigned();
            $table->enum('fee_type',['class_fee','registration_fee']);           
            $table->timestamp('payment_date')->nullable();
            $table->integer('currency_id')->unsigned();
            $table->decimal('amount',10,2)->unsigned();
            $table->integer('no_of_classes')->unsigned();
            $table->integer('payment_method_id')->unsigned();
            $table->enum('status',['pending','paid','failed'])->default('pending');
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
        Schema::dropIfExists('payment_histories');
    }
}
