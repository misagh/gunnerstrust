<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEmbedFieldsInPodcastsAndInterviewsTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interviews', function (Blueprint $table)
        {
            $table->string('file')->after('embed')->nullable();
        });

        Schema::table('podcasts', function (Blueprint $table)
        {
            $table->string('file')->after('embed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interviews', function (Blueprint $table)
        {
            $table->dropColumn('audio_file');
        });

        Schema::table('podcasts', function (Blueprint $table)
        {
            $table->dropColumn('audio_file');
        });
    }
}
