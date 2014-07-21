<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('openid');
			$table->string('msg_type');
			$table->string('content');
			$table->string('pic_url');
			$table->string('media_id');
			$table->string('format'); // used for voice message
			$table->string('thumb_media_id');
			$table->string('event');
			$table->string('event_key');
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
		Schema::drop('wechat_messages');
	}

}
