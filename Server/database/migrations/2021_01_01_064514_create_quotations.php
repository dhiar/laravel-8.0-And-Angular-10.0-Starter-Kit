<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Quotations', function (Blueprint $table) {
          $table->id();
          $table->string('reference_no');
          $table->date('created_date');
          $table->integer('client_id');
          $table->integer('site_id');
          $table->string('contacted_person');
          $table->string('contacted_person_email1');
          $table->string('contacted_person_email2');
          $table->string('contacted_person_phone');
          $table->string('quotation_status_id');
          $table->string('quotation_notes');
          $table->string('quotation_validity_date');
          $table->string('estimated_completed_date');
          $table->string('attachment');
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
        Schema::dropIfExists('quotations');
    }
}
