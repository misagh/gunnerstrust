<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color')->nullable();
        });

        Schema::create('category_update', function (Blueprint $table)
        {
            $table->unsignedInteger('update_id');
            $table->unsignedInteger('category_id');

            $table->primary(['update_id', 'category_id']);

            $table->foreign('update_id')->references('id')->on('updates');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
