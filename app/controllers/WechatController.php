<?php

class WechatController extends BaseController
{
	public $wechat;
	public $uid;
	public $options;

	public function __construct()
	{
		$this->options = array(
			'token' => 'newvoice',
			'appid' => 'wxa21bfbc1cd3c446b',
			'appsecret'=> 'c8c3f1810dcaab0e66807ccc2f4bef1e',
		);
		$this->wechat = new Wechat($this->options);
		$this->wechat->getRev();
		$this->uid = User::openidToUid($this->wechat->getRevFrom());
		Log::info('openid:'.$this->wechat->getRevFrom());
		Log::info('uid:'.$this->uid);
		$queries = DB::getQueryLog();
		$last_query = end($queries);
		Log::info('last sql:'.print_r($last_query, true));
	}

	public function index()
	{
		$this->wechat->valid();
		$type = $this->wechat->getRevType();
		$result = null;
		switch ($type) {
			case Wechat::MSGTYPE_EVENT:
				$event = $this->wechat->getRevEvent();
				if ($event['event'] == 'subscribe') {
					$result = $this->subscribe();
				} else {
					if (!$this->checkBind()) {
						$result['type'] = 'text';
						$result['content'] = '您的账号未绑定，请发送： bd+key 如  bdxxxx 进行绑定。';
						break;
					}
					if ($event['event'] == 'CLICK') {
						if ($event['key'] == 'add_lecture') {
							$result = $this->addLecture();
						} elseif ($event['key'] == 'edit_lecture') {
							$result = $this->editLecture();
						} elseif ($event['key'] == 'view_lecture') {
							$result = $this->viewLecture();
						}
					}
				}
				break;
			case Wechat::MSGTYPE_TEXT:
				$this->recordText();
				$content = $this->wechat->getRevContent();
				$matches = null;
				if (!$this->checkBind()) {
					$result['type'] = 'text';
					if (preg_match('#^bd([^\s]+)#', $content, $matches)) {
						$user = User::whereRaw('username = ?', array($matches[1]))->first();
						if (is_null($user)) {
							$result['content'] = '帐号不存在。';
							// $this->wechat->text('帐号不存在。')->reply();
						} else {
							$user->openid = $this->wechat->getRevFrom();
							$user->save();
							$result['content'] = '恭喜您绑定成功。';
							// $this->wechat->text('恭喜您绑定成功。')->reply();
						}
					} else {
						$result['content'] = '您的账号未绑定，请发送： bd+key 如  bdxxxx 进行绑定。';
						// $this->wechat->text('您的账号未绑定，请发送： bd+key 如  bdxxxx 进行绑定。')->reply();
					}
					break;
				}
				// has bind in following line 
				$lastReply = WechatReply::getLastReply($this->wechat->getRevFrom());
				if (is_null($lastReply)) {
					$type = 0;
				} else {
					$type = $lastReply->type;
				}
				// dispatch according to the type
				if (in_array($type, array(1))) {
					$result = $this->addLecture();
				}
				break;
			case Wechat::MSGTYPE_IMAGE:
				$lastReply = WechatReply::getLastReply($this->wechat->getRevFrom());
				if (is_null($lastReply)) {
					$type = 0;
				} else {
					$type = $lastReply->type;
				}
				// dispatch according to the type
				if (in_array($type, array(2))) {
					$result = $this->addLecture();
				}
				break;
			case Wechat::MSGTYPE_VIDEO:
				$lastReply = WechatReply::getLastReply($this->wechat->getRevFrom());
				if (is_null($lastReply)) {
					$type = 0;
				} else {
					$type = $lastReply->type;
				}
				// dispatch according to the type
				if (in_array($type, array(3))) {
					$result = $this->addLecture();
				}
				break;
			default:
				// $this->wechat->text('oops，我是小新，正在处理您的请求。')->reply();
				break;
		}
		if (is_null($result)) {
			$this->wechat->text('oops，我是小新，正在处理您的请求。')->reply();
		} else {
			if ($result['type'] == 'text') {
				if (empty($result['content'])) {
					$this->wechat->text('content is empty.')->reply();
				} else {
					$this->wechat->text($result['content'])->reply();
				}
			} elseif ($result['type'] == 'news') {
				$this->wechat->news($result['news'])->reply();
			}
		}
	}

	private function subscribe()
	{
		$result['type'] = 'news';
		$result['news'][0]['Title'] = '新生 · 让听障儿童重获新声';
		$result['news'][0]['Description'] = '';
		$result['news'][0]['PicUrl'] = 'http://mmbiz.qpic.cn/mmbiz/bgmKymQH9icNuJcLaDALTX9yQav8cic5GlwQ9ibr2ndLUH9gcYEWBXzhleNWZHYsiaEX8aOzMTA6OtfaZNjgj4hicAQ/0';
		$result['news'][0]['Url'] = 'http://mp.weixin.qq.com/s?__biz=MzA3NTc3NjkwMg==&mid=200539984&idx=1&sn=304988dad1bfb9abf7e0038e948217b2&scene=1&from=singlemessage&isappinstalled=0#rd';
		// $this->wechat->text('欢迎关注新声微信公众帐号！')->reply();
		return $result;
	}

	private function addLecture()
	{
		// $lastReply = null;
		$lastReply = WechatReply::getLastReply($this->wechat->getRevFrom());
		// Log::info('last reply type: '.$lastReply->type);
		$result['type'] = 'text';
		if (is_null($lastReply) or !in_array($lastReply->type, array(1,2,3))) {
			$result['content'] = '请回复课程名称';
			$this->recordReply(1);
		} elseif ($lastReply->type == 1) {
			$lecture = new Lecture();
			$lecture->uid = $this->uid;
			$lecture->name = $this->wechat->getRevContent();
			$lecture->pinyin = implode('|', $this->toPinyin($lecture->name));
			$lecture->sort = Lecture::whereRaw('uid = ?', array($this->uid))->max('sort') + 2;
			$queries = DB::getQueryLog();
			$last_query = end($queries);
			Log::info('last sql:'.print_r($last_query, true));
			$lecture->save();
			Log::info('sort:'.$lecture->sort);
			
			$result['content'] = '请上传课程图片';
			$this->recordReply(2, $lecture->id);
		} elseif ($lastReply->type == 2) {
			// handle the uploaded picture
			$lectureId = $lastReply->content;
			Queue::push('JobWechat@pullLecturePic',
				array(
					'options' => $this->options,
					'lectureId' => $lectureId,
					'media_id' => $this->wechat->getMediaId(),
				)
			);
			$result['content'] = '请上传学习视频';
			$this->recordReply(3, $lectureId);
		} elseif ($lastReply->type == 3) {
			$lectureId = $lastReply->content;
			Queue::push('JobWechat@pullLectureVideo',
				array(
					'options' => $this->options,
					'lectureId' => $lectureId,
					'media_id' => $this->wechat->getMediaId(),
				)
			);
			Log::info('queue successfully');
			$result['content'] = '添加课程成功！';
			$this->recordReply(4, $lectureId);
		}
		return $result;
	}

	private function viewLecture()
	{
		$result['type'] = 'text';
		$lectures = Lecture::whereRaw('uid = ?', array($this->uid))->get();
		if (is_null($lectures)) {
			$result['content'] = '当前未添加课程，赶紧录制一段吧。';
		} else {
			$result['content'] = '';
			foreach ($lectures as $key=>$lecture) {
				$result['content'] .= ($key+1).'>'.$lecture->name."\n";
			}
		}
		return $result;
	}

	private function editLecture()
	{
		$result['type'] = 'text';
		$result['content'] = '编辑功能即将上线。';
		return $result;
	}

	private function checkBind()
	{
		$openid = $this->wechat->getRevFrom();
		Log::info('openid:'.$this->wechat->getRevFrom());
		$count = User::whereRaw('openid = ?', array($openid))->count();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}

	private function recordText()
	{
		$message = new WechatMessage();
		$message->openid = $this->wechat->getRevFrom();
		$message->msg_type = 'text';
		$message->content = $this->wechat->getRevContent();
		$message->save();
	}

	private function recordMenu()
	{
		$message = new WechatMessage();
		$message->openid = $this->wechat->getRevFrom();
		$message->msg_type = 'event';
		$event = $this->wechat->getRevEvent();
		if ($event['event'] == 'CLICK') {
			$message->event = 'CLICK';
			$message->event_key = $event['key'];
		} else {
			$message->event = 'VIEW';
			$message->event_key = $event['key'];
		}
		$message->save();
	}

	private function recordReply($type, $content='')
	{
		$reply = new WechatReply();
		$reply->openid = $this->wechat->getRevFrom();
		$reply->type = $type;
		if (!empty($content)) {
			$reply->content = $content;
		}
		$reply->save();
	}

	public function createMenu()
	{
		$menu = array(
			'button' => array(
				array(
					'name' => '课程',
					'sub_button' => array(
						array(
							'type' => 'click',
							'name' => '添加',
							'key' => 'add_lecture'
						),
						array(
							'type' => 'click',
							'name' => '查看',
							'key' => 'view_lecture'
						),
						array(
							'type' => 'click',
							'name' => '编辑',
							'key' => 'edit_lecture'
						),
					),
				),
			)
		);
		print_r($menu);
		$result = $this->wechat->createMenu($menu);
		if ($result) {
			echo 'create menu successfully!';
		}
	}

	public function toPinyin($char)
	{
		$strArray = $this->implode_str($char);
		$pytable = unserialize(file_get_contents('pinyin/pytable_with_tune.txt'));
		$result = array();
		foreach ($strArray as $str) {
			$result[] = $pytable[$str][0];
		}
		return $result;
	}

	public function implode_str($string)
	{
		$len = mb_strlen($string);
		$result = array();
		$i = 0;
		while ($i < $len) {
			$result[] = mb_substr($string, $i, 1);
			$i += 1;
		}
		return $result;
	}


}