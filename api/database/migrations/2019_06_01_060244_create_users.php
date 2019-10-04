<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('use_id');
            $table->integer('use_master_id');
            $table->integer('use_permission_id');
            $table->text('use_location');
            $table->string('use_fullname',255);
            $table->string('use_email',255);
            $table->string('use_password_code', 32);
            $table->string('use_salt', 32);
            $table->string('use_code', 50);
            $table->timestamp('use_created_at')->useCurrent();
            $table->timestamp('use_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
