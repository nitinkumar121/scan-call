<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_barcodes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->char('barcode');
            $table->enum('status' ,array('0','1','2'));
            $table->enum('payment_status' , array('0','1','2','3'));
            $table->dateTime('payment_date');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_barcodes');
    }
}
