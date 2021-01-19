<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductVender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('product_vender', function (Blueprint $table) {
          $table->id();
          $table->string('vender_name');
          $table->string('vender_first_email')->unique();
          $table->string('vender_second_email');
          $table->string('phone');
          $table->string('address');
          $table->integer('country');
          $table->integer('city');
          $table->integer('state');
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
