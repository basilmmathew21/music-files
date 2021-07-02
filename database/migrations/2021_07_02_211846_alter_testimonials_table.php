<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            \DB::statement("ALTER TABLE testimonials MODIFY `status` ENUM('pending','approved', 'rejected')  DEFAULT 'pending';");
             \DB::statement("ALTER TABLE testimonials MODIFY `is_active` TinyInt(1) DEFAULT 0;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            \DB::statement("ALTER TABLE testimonials MODIFY `status` ENUM('pending','approved', 'rejected')  NULL;");
            \DB::statement("ALTER TABLE testimonials MODIFY `is_active` TinyIntDEFAULT 0;");
        });
    }
}
