<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenaltyScoreToFixturesAndGamesTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fixtures', function (Blueprint $table)
        {
            $table->boolean('penalty')->after('score2')->default(0);

            $table->unsignedInteger('penalty1')->after('penalty')->nullable();
            $table->unsignedInteger('penalty2')->after('penalty1')->nullable();
        });

        Schema::table('games', function (Blueprint $table)
        {
            $table->unsignedInteger('winner_id')->after('fixture_id')->nullable();

            $table->foreign('winner_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fixtures', function (Blueprint $table)
        {
            $table->dropColumn('penalty1');
            $table->dropColumn('penalty2');
        });

        Schema::table('games', function (Blueprint $table)
        {
            $table->dropForeign(['winner_id']);
            $table->dropColumn('winner_id');
        });
    }
}
