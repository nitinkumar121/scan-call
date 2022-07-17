<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVechileDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vechile_details', function (Blueprint $table) {
            $table->id();
            $table->int('user_id');
            $table->text('vechile_name');
            $table->char('vechile_number');
            $table->char('vechile_model');
            $table->char('vechile_rc_number');
            $table->char('vechile_rc_back_image');
            $table->char('vechile_rc_front_image');
            $table->integer('barcode_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vechile_details');
    }
}
