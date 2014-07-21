<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLectureTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('lectures', function($t) {
            $t->increments('id');
            $t->integer('uid')->unsigned();
            $t->string('name', 20);
            $t->string('pinyin', 50);
            $t->string('yes_pic_path', 64);
            $t->string('no_pic_path', 64);
            $t->string('video_path', 64);
            $t->bigInteger('video_start');
            $t->double('voice_start');
            $t->double('voice_end');
            $t->double('sort')->default(0);
            $t->timestamps();
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
        Schema::table('lectures', function($t)
        {
            $t->dropForeign('lectures_uid_foreign');
        });
		Schema::drop('lectures');
	}

}
