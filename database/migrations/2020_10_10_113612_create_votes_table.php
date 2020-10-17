<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('discussion_id');
            $table->unsignedInteger('option_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('discussion_id')->references('id')->on('discussions');
            $table->foreign('option_id')->references('id')->on('options');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unique(['discussion_id', 'option_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
