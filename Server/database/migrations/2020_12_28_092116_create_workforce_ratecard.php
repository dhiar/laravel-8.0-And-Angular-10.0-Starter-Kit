<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkforceRatecard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workforce_rate_card', function (Blueprint $table) {
            $table->id();
            $table->string('Category_name');
            $table->string('sub_category');
            $table->string('normal_rate');
            $table->string('overtime_rate');
            $table->string('weekend_rate');
            $table->string('public_holiday_rate');
            $table->string('is_active');
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
        Schema::dropIfExists('workforce_ratecard');
    }
}
