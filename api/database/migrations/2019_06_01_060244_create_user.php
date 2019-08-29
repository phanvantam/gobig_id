<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('use_id');
            $table->integer('use_type');
            $table->string('use_name',255);
            $table->string('use_mail',255);
            $table->string('use_password',255);
            $table->string('use_token',255);
            $table->timestamp('use_created_at')->useCurrent();
            $table->timestamp('use_updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
