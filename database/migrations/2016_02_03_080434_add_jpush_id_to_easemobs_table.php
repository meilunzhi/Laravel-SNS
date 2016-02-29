<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJpushIdToEasemobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('easemobs', function (Blueprint $table) {
            $table->string('jpush_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('easemobs', function (Blueprint $table) {
            $table->dropColumn('jpush_id');
        });
    }
}
