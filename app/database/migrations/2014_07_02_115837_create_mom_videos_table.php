<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMomVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('mom_videos', function($t) {
            $t->increments('id');
            $t->integer('uid')->unsigned();
            $t->string('path');
            $t->timestamps();
            $t->tinyInteger('status')->default(1);
            $t->foreign('uid')->references('id')->on('users')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('mom_videos', function($t)
		{
		    $t->dropForeign('mom_videos_uid_foreign');
		});
		Schema::drop('mom_videos');
	}

}
