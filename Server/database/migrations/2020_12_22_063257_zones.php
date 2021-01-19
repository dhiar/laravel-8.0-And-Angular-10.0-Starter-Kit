<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Zones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('zones', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('country_id');
          $table->integer('city_id');
          $table->integer('state_id');
          $table->string('latitude');
          $table->string('longitude');
          $table->string('radius');
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
