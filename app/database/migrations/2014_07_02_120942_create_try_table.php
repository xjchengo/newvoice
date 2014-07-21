<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('tries', function($t) {
            $t->increments('id');
            $t->integer('uid')->unsigned();
            $t->integer('lecture_id')->unsigned();
            $t->string('path'); //视频地址
            $t->float('score');
            $t->string('recog_result'); //识别结果
            $t->timestamps();
            $t->foreign('uid')->references('id')->on('users')->onDelete('cascade');;
            $t->foreign('lecture_id')->references('id')->on('lectures')->onDelete('cascade');;
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
		Schema::table('tries', function($t)
		{
		    $t->dropForeign('tries_uid_foreign');
		    $t->dropForeign('tries_lecture_id_foreign');
		});
		Schema::drop('tries');
	}

}
