<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkForceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_force', function (Blueprint $table) {
            $table->id();
            $table->integer('job_nature_id')->nullable();
            $table->integer('work_role_id')->nullable();
            $table->integer('discipline_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('agency')->nullable();
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
        Schema::dropIfExists('work_force');
    }
}
