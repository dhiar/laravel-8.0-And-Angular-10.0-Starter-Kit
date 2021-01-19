<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Material extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('material', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->integer('category_id');
          $table->integer('unit_price');
          $table->integer('currency');
          $table->integer('unit');
          $table->string('sku_no');
          $table->integer('reference_no_vender');
          $table->text('description')->nullable();
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
