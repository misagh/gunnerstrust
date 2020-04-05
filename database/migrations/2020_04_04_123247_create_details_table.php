<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->text('about')->nullable();
            $table->year('year')->nullable();
            $table->string('player')->nullable();
            $table->string('manager')->nullable();
            $table->string('national')->nullable();
            $table->string('number')->nullable();
            $table->string('team')->nullable();
            $table->string('legend')->nullable();
            $table->string('moment')->nullable();
            $table->unsignedTinyInteger('fan')->default(0);
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
        Schema::dropIfExists('details');
    }
}
