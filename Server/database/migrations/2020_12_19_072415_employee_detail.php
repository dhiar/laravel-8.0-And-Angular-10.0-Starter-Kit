<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('employee_detail', function (Blueprint $table) {
          $table->id();
          $table->string('category_name');
          $table->integer('user_id');
          $table->integer('category_id');
          $table->text('wrench_time');
          $table->integer('zone_id');
          $table->integer('agency_id');
          $table->string('employee_type');
          $table->integer('is_active');
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
        //
    }
}
