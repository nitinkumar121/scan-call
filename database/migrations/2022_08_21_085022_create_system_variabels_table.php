<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemVariabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_variabels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('current_version');
            $table->string('base_url');
            $table->string('notification_email');
            $table->string('notification_email_password');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_variabels');
    }
}
