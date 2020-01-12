<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoredPasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stored_passwords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_token');
            $table->string('email');
            $table->string('password');
            $table->string('iv');
            $table->string('website_name');
            $table->string('website_url');
            $table->string('image_url');
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
        Schema::dropIfExists('stored_passwords');
    }
}
