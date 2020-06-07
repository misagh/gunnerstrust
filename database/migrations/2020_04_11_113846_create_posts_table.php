<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('challenge_id')->nullable();
            $table->boolean('verified')->default(false)->index();
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->string('summary');
            $table->text('body');
            $table->string('cover')->nullable();
            $table->unsignedInteger('hit')->default(0)->index();
            $table->string('tip')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('challenge_id')->on('challenges')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
