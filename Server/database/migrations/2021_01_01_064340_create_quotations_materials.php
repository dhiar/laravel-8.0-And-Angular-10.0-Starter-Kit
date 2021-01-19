<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('quotations_materials', function (Blueprint $table) {
          $table->id();
          $table->integer('quotation_id');
          $table->integer('material_id');
          $table->string('qty');
          $table->string('price');
          $table->integer('currency_id');
          $table->integer('vender_id');
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
        Schema::dropIfExists('quotations_materials');
    }
}
