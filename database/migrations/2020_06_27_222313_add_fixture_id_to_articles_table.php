<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFixtureIdToArticlesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table)
        {
            $table->unsignedInteger('fixture_id')->after('user_id')->nullable();

            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table)
        {
            $table->dropForeign(['fixture_id']);
            $table->dropColumn('fixture_id');
        });
    }
}
