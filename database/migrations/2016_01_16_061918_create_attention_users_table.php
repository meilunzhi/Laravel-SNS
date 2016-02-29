<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttentionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attention_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('attention_user_id');
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
        Schema::table('attention_users', function (Blueprint $table) {
            $table->drop('attention_users');
        });
    }
}
