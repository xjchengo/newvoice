<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
       $this->call('LectureTableSeeder');
       $this->call('TryItTableSeeder');
   }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
           'username' => 'xjchen',
           'password' => Hash::make('123456')
           )
        );
        User::create(array(
           'username' => 'yy',
           'password' => Hash::make('123456'),
           'openid' => '123',
           )
        );
    }
}

class LectureTableSeeder extends Seeder {

    public function run()
    {
        DB::table('lectures')->delete();

        Lecture::create(array(
            'uid' => 1,
            'name' => '葡萄',
            'pinyin' => 'pú|táo',
            'yes_pic_path' => '/img/home/Homepage_Pic_Grape.png',
            'no_pic_path' => '/img/home/Homepage_Pic_Grape.png',
            'video_path' => '/wechat_mp4/71404732446.mp4',
            'voice_start'=>'1000',
            'voice_end'=>'3000',
            'sort' => 1,
            )
        );
        Lecture::create(array(
            'uid' => 1,
            'name' => '苹果',
            'pinyin' => 'píng|guǒ',
            'yes_pic_path' => '/img/home/Homepage_Pic_Apple.png',
            'no_pic_path' => '/img/home/Homepage_Pic_Apple.png',
            'video_path' => '/wechat_mp4/111404732467.mp4',
            'voice_start'=>'1900',
            'voice_end'=>'3500',
            'sort' => 2,
            )
        );
        Lecture::create(array(
            'uid' => 1,
            'name' => '桃子',
            'pinyin' => 'táo|zǐ',
            'yes_pic_path' => '/img/home/Homepage_Pic_Peach.png',
            'no_pic_path' => '/img/home/Homepage_Pic_Peach.png',
            'video_path' => '/wechat_mp4/101404732461.mp4',
            'voice_start'=>'900',
            'voice_end'=>'2500',
            'sort' => 3,
            )
        );
        Lecture::create(array(
            'uid' => 1,
            'name' => '西瓜',
            'pinyin' => 'xī|guā',
            'yes_pic_path' => '/img/home/Homepage_Pic_Watermelon.png',
            'no_pic_path' => '/img/home/Homepage_Pic_Watermelon.png',
            'video_path' => '/wechat_mp4/91404732455.mp4',
            'voice_start'=>'1200',
            'voice_end'=>'2800',
            'sort' => 4,
            )
        );
    }
}

class TryItTableSeeder extends Seeder {

    public function run()
    {
        DB::table('tries')->delete();

        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-01 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-02 16:33:39',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-02 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-02 16:34:59',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-02 16:35:39',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-02 16:36:19',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-02 16:36:53',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-02 16:37:34',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-02 16:38:06',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-02 16:38:52',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-02 16:39:44',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-02 16:40:14',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-02 16:40:51',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-03 14:12:34',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-03 14:13:24',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-03 14:14:58',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-03 14:15:38',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-03 14:16:04',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-03 14:12:34',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-03 14:13:14',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-03 14:13:54',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-03 14:14:38',   
           )
        ); 
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-03 14:15:04',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-03 14:17:34',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-04 14:18:14',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 1,
           'created_at' => '2014-07-04 14:18:54',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-04 14:19:34',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-04 14:19:59',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-04 14:20:34',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-04 14:21:04',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-04 14:21:48',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-04 14:22:20',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-05 20:30:04',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-05 20:30:44',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-05 20:31:24',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-05 20:31:58',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-05 20:32:33',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-05 20:33:04',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-05 20:33:46',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-05 20:34:14',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-05 20:34:54',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-06 16:20:03',   
           )
        ); TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-06 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 2,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 2,
           'score' => 3,
           'created_at' => '2014-07-07 16:20:03',   
           )
        );


        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 1,
           'created_at' => '2014-07-02 16:20:03',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 1,
           'created_at' => '2014-07-02 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 1,
           'created_at' => '2014-07-02 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 1,
           'created_at' => '2014-07-02 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-02 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-02 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-02 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 1,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 1,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 1,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 1,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 3,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );



        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 1,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 1,
           'created_at' => '2014-07-03 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 1,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-04 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 3,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-05 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 1,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-06 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 1,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 2,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );
        TryIt::create(array(
           'uid' => 1,
           'lecture_id'=> 4,
           'score' => 3,
           'created_at' => '2014-07-07 16:34:16',   
           )
        );

    }
}


