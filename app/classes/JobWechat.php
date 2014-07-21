<?php

class JobWechat
{
	public function test($job, $data)
	{
		Log::info('JobWechat test');
		Log::info(print_r($data, true));
		$job->delete();
	}

	public function pullLecturePic($job, $data)
	{
		$wechat = new Wechat($data['options']);
		$urlTempl = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=%s&media_id=%s";
		$url = sprintf($urlTempl, $wechat->checkAuth(), $data['media_id']);
		$filename = $data['lectureId'].time().'.jpg';
		$dir = '/wechat_pic/';
		Log::info($url);
		Log::info(".{$dir}{$filename}");
		$fp = fopen ("./public/{$dir}{$filename}", 'w');//This is the file where we save the    information
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch); // get curl response
		curl_close($ch);
		fclose($fp);
		$lecture = Lecture::find($data['lectureId']);
		$lecture->yes_pic_path = $dir.$filename;
		$lecture->save();
		$job->delete();
	}

	public function pullLectureVideo($job, $data)
	{
		$wechat = new Wechat($data['options']);
		$urlTempl = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=%s&media_id=%s";
		$url = sprintf($urlTempl, $wechat->checkAuth(), $data['media_id']);
		$filename = $data['lectureId'].time().'.mp4';
		$dir = '/wechat_mp4/';
		Log::info($url);
		Log::info(".{$dir}{$filename}");
		$fp = fopen ("./public/{$dir}{$filename}", 'w');//This is the file where we save the    information
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch); // get curl response
		curl_close($ch);
		fclose($fp);
		$lecture = Lecture::find($data['lectureId']);
		$lecture->video_path = $dir.$filename;
		$lecture->save();
		$job->delete();
	}
}