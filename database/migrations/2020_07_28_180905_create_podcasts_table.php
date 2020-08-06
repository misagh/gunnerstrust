<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodcastsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary');
            $table->text('body')->nullable();
            $table->string('cover');
            $table->text('embed')->nullable();
            $table->unsignedInteger('hit')->default(0)->index();
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
        Schema::dropIfExists('podcasts');
    }
}
