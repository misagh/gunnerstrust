<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->boolean('pinned')->default(false)->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary');
            $table->text('body');
            $table->string('cover');
            $table->string('source')->nullable();
            $table->unsignedInteger('hit')->default(0)->index();
            $table->timestamps();

            $table->index('created_at');
            $table->index('updated_at');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
