<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixturesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('team1_id');
            $table->unsignedInteger('team2_id');
            $table->unsignedInteger('stadium_id');
            $table->unsignedInteger('competition_id');
            $table->unsignedTinyInteger('score1')->nullable()->index();
            $table->unsignedTinyInteger('score2')->nullable()->index();
            $table->year('season')->index();
            $table->unsignedTinyInteger('matchday')->nullable();
            $table->string('slug')->index();
            $table->text('body')->nullable();
            $table->timestamp('played_at')->index();

            $table->foreign('team1_id')->references('id')->on('teams');
            $table->foreign('team2_id')->references('id')->on('teams');
            $table->foreign('stadium_id')->references('id')->on('stadiums');
            $table->foreign('competition_id')->references('id')->on('competitions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixtures');
    }
}
