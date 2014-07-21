<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function login()
	{
		$rules = array(
			'username' => 'required|alphaNum|min:3', // make sure the email is an actual email
			'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return Redirect::to('login')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {

			// create our user data for the authentication
			$userdata = array(
				'username' 	=> Input::get('username'),
				'password' 	=> Input::get('password')
			);

			// attempt to do the login
			if (Auth::attempt($userdata)) {

				// validation successful!
				// redirect them to the secure section or whatever
				// return Redirect::to('secure');
				// for now we'll just echo success (even though echoing in a controller is bad)
				return Redirect::to('home');

			} else {	 	

				// validation not successful, send back to form	
				return Redirect::to('login');

			}

		}
	}

	public function uploadWebm($lecture_id)
	{
		$destinationPath = './upload_webm/';
		$fileName = time().'.webm';
		Input::file('webm')->move($destinationPath, $fileName);
		$path = substr($destinationPath, 1).$fileName;
		$lecture = Lecture::find($lecture_id);
		$lecture->video_path = $path;
		$lecture->save();
		return Response::json(array('status' => '1'));
	}

	public function index()
	{
		$uid = Auth::id();
		$lectures = Lecture::whereRaw('uid = ?', array($uid))->orderBy('sort', 'asc')->get();
		foreach ($lectures as &$lecture) {
			$lecture->star = $this->evaluate($uid, $lecture->id);
		}
		// dd(DB::getQueryLog());
		// print_r($lectures);
		return View::make('home')->with('lectures', $lectures);
	}

	public function toPinyin($char)
	{
		$strArray = $this->implode_str($char);
		$pytable = unserialize(file_get_contents('pinyin/pytable_with_tune.txt'));
		$result = array();
		foreach ($strArray as $str) {
			$result[] = $pytable[$str][0];
		}
		die(implode('|', $result));
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

	public function tryit($lecture_id)
	{
		$try = new TryIt();
		$try->uid = Auth::id();
		$try->lecture_id = $lecture_id;
		$try->score = rand(0, 3);
		$try->path = Input::get('path');
		$try->recog_result = Input::get('pinyin');
		$try->save();
	}

	public function progress()
	{
		$uid = Auth::id();
		$lectures = Lecture::whereRaw('uid = ?', array($uid))->get();
		$lectureById = array();
		foreach ($lectures as $lecture) {
			$lectureById[$lecture->id]['id'] = $lecture->id;
			$lectureById[$lecture->id]['name'] = $lecture->name;
		}
		// print_r($lectureById);
		$tries = TryIt::whereRaw('uid = ?', array($uid))->orderBy('created_at', 'asc')->get();
		$passL = array();
		$wholeL = array();
		$passNum = 0;
		$lectureUnique = array();
		foreach ($tries as $t) {
			$thisTime = strtotime($t->created_at);
			$timeStr = date('m.d', $thisTime);
			$lectureUnique[] = $t->lecture_id;
			if (!isset($passL[$timeStr])) {
				$passL[$timeStr] = array();
			}
			// echo $timeStr.'<br>';
			if (intval($t->score) == 3) {
				// echo $t->score.'<br>';
				$passL[$timeStr][] = $t->lecture_id;
			}
			$wholeL[$timeStr][] = $t->lecture_id;
		}
		$allLecturesNum = count(array_unique($lectureUnique));
		$dayNum = count($wholeL);
		$passNumEveryday = array();
		foreach ($passL as &$p) {
			$p = array_values(array_unique($p));
			$passNum += count($p);
			$passNumEveryday[] = count($p);
		}
/*		print_r($passNumEveryday);
		print_r($wholeL);*/
		$categories = array();
		$noPassNumEveryday = array();
		$i = 0;
		foreach ($wholeL as $key=>&$w) {
			$categories[] = $key;
			$w = array_values(array_unique($w));
			if (isset($passNumEveryday[$i])) {
				$noPassNumEveryday[] = count($w) - $passNumEveryday[$i];
			} else {
				$noPassNumEveryday[] = count($w) - 0;
			}
			$i += 1;
		}
		// print_r($passL);
		// print_r($wholeL);

		return View::make('progress')->with('passNum', $passNum)
			->with('dayNum', $dayNum)
			->with('categories', json_encode($categories))
			->with('passNumEveryday', json_encode($passNumEveryday))
			->with('noPassNumEveryday', json_encode($noPassNumEveryday))
			->with('passL', json_encode($passL))
			->with('wholeL', json_encode($wholeL))
			->with('lectures', json_encode($lectureById))
			->with('allLecturesNum', $allLecturesNum);
	}

	public function history($lecture_id)
	{
		$lecture = Lecture::whereRaw('id = ?', array($lecture_id))->first();
		$uid = Auth::id();
		$tries = TryIt::whereRaw('uid = ? and lecture_id = ?', array($uid, $lecture_id))->orderBy('created_at', 'asc')->get();
		$tryByDay = array();
		foreach ($tries as $t) {
			$thisTime = strtotime($t->created_at);
			$timeStr = date('m.d', $thisTime);
			$tryByDay[$timeStr][] = $t->score; 		
		}
		// print_r($tryByDay);
		$timeSeries = array();
		foreach ($tryByDay as $key=>$t) {
			$timeSeries[] = $key;
		}
		$accuracy = array();
		foreach ($tryByDay as $day) {
			$whole = count($day);
			$a = 0;
			foreach ($day as $score) {
				if (intval($score) == 3) {
					$a += 1;
				}
			}
			// echo "$a $whole".'<br>';
			$ac = intval(($a/$whole)*1000)/10;
			// echo $ac.'<br>';
			$accuracy[] = $ac;
			$lastAccuracy = $ac;
		}
		return View::make('history')->with('timeSeries', json_encode($timeSeries))
			->with('accuracy', json_encode($accuracy))
			->with('lecture', $lecture)
			->with('wholeday', count($timeSeries))
			->with('lastAccuracy', $lastAccuracy);
	}

	public function insertVoiceTime($lecture_id)
	{
		$lecture = Lecture::find($lecture_id);
		$lecture->voice_start = Input::get('voice_start');
		$lecture->voice_end = Input::get('voice_end');
		$lecture->save();
		return Response::json(array('status' => '1'));
	}

	public function updateVideoStart($lecture_id)
	{
		$lecture = Lecture::find($lecture_id);
		$lecture->video_start = $this->microTime();
		$lecture->save();
		return Response::json(array('status' => '1'));
	}

	public function signal($uid)
	{
		$lectures = Lecture::whereRaw('uid = ?', array($uid))->get();
		$nTime = $this->microTime();
		// echo "nTime".$nTime;
		foreach ($lectures as $lecture) {
			$vStart = ($lecture->video_start?$lecture->video_start:0) + $lecture->voice_start;
			$vEnd = ($lecture->video_start?$lecture->video_start:0) + $lecture->voice_end;
			/*echo "vStart".$vStart;
			echo "vEnd".$vEnd;*/
			if ($lecture->id == 1) {
				if ($nTime > $vStart and $nTime < $vEnd) {
					if ($nTime < ($vStart + ($vEnd - $vStart)/2)) {
						echo "100\n100";
					} elseif ($nTime < ($vStart + ($vEnd - $vStart)*2/2)) {
						echo "70\n70";
					}
					exit();
				}
			} elseif ($lecture->id == 2) {
				if ($nTime > $vStart and $nTime < $vEnd) {
					if ($nTime < ($vStart + ($vEnd - $vStart)/2)) {
						echo "100\n100";
					} elseif ($nTime < ($vStart + ($vEnd - $vStart)*2/2)) {
						echo "0\n70";
					}
					exit();
				}
			} elseif ($lecture->id == 3) {
				if ($nTime > $vStart and $nTime < $vEnd) {
					if ($nTime < ($vStart + ($vEnd - $vStart)/2)) {
						echo "70\n100";
					} elseif ($nTime < ($vStart + ($vEnd - $vStart)*2/2)) {
						echo "0\n70";
					}
					exit();
				}
			} elseif ($lecture->id == 4) {
				if ($nTime > $vStart and $nTime < $vEnd) {
					if ($nTime < ($vStart + ($vEnd - $vStart)/2)) {
						echo "100\n70";
					} elseif ($nTime < ($vStart + ($vEnd - $vStart)*2/2)) {
						echo "0\n100";
					}
					exit();
				}
			}

/*			$resultArray = array("40\n40", "70\n70", "100\n100");
			if ($nTime > $vStart and $nTime < $vEnd) {
				if ($nTime < ($vStart + ($vEnd - $vStart)/3)) {
					$indexA = rand(0, 2);
					echo $resultArray[$indexA];
				} elseif ($nTime < ($vStart + ($vEnd - $vStart)*2/3)) {
					$indexA = rand(0, 2);
					echo $resultArray[$indexA];
				} else {
					$indexA = rand(0, 2);
					echo $resultArray[$indexA];
				}
				
				exit();
			}*/
		}
		echo "0\n0";
	}

	public function microTime()
	{
		list($usec, $sec) = explode(" ", microtime());
		return intval($sec*1000 + $usec*1000);
	}

	public function uploadVoice($lecture_id)
	{
		if (Input::hasFile('wav')) {
			if (!Input::file('wav')->isValid()) {
				return Response::json(array('status' => '0', 'info'=>'wav not valid'));
			}
			$filename = time().'.wav';
			if (!Input::file('wav')->move('./audio', $filename)) {
				return Response::json(array('status' => '0', 'info'=>'move file failed'));
			}
			exec('sox ./audio/'.$filename.' -r 16000 '.'./audio/16k'.$filename);
			exec('iatdemo ./audio/16k'.$filename, $output, $return_var);
			/*echo url('/audio/16k'.$filename);
			echo $return_var.'<br>';
			print_r($output);*/
			$result['success'] = 0;
			foreach($output as $key=>$value) {
				if (!isset($output[$key+2])) {
					break;
				}
	            if ((mb_substr($value, 0, 5) == '=====') and (mb_substr($output[$key+2], 0, 5) == '=====')) {
	            	$char = $output[$key+1];
	            	if (mb_strlen($char) > 5) {
	            		$result['success'] = 0;
	            		$result['info'] = 'to long';
	            	} else {
	            		$result['success'] = 1;
	            		$result['character'] = mb_substr($char, 0, 2);
	            		$pinyin = $this->toPY($result['character']);
	            		$lecture = Lecture::whereRaw('id = ?', array($lecture_id))->first();
	            		$targetPinyin = explode('|', $lecture->pinyin);
	            		$score = 0;
	            		foreach ($targetPinyin as $key=>$t) {
	            			if (isset($pinyin[$key])) {
	            				$score += $this->pyScore($t, $pinyin[$key]);
	            			} else {
	            				$score += 0;
	            			}
	            		}
	            		foreach ($targetPinyin as $key=>$t) {
	            			if (isset($pinyin[$key])) {
	            				$result['pinyin'][] = $this->pyScoreMark($t, $pinyin[$key]);
	            			}
	            		}
	            		if (isset($result['pinyin'])) {
	            			$result['pinyin'] = json_encode($result['pinyin']);
	            		} else {
	            			$result['pinyin'] = '';
	            		}
	            		
	            		$result['score'] = intval($score/2);
	            		$result['path'] = url('/audio/16k'.$filename);
	            		$try = new TryIt();
						$try->uid = Auth::id();
						$try->lecture_id = $lecture_id;
						$try->score = $result['score'];
						$try->path = url('/audio/16k'.$filename);
						$try->recog_result = implode('|', $pinyin);
						$try->save();
	            	}
	                break;
	            }
	        }
	        die(json_encode($result));
		} else {
			return Response::json(array('status' => '0', 'info'=>'no file wav'));
		}
	}

	public function evaluate($uid, $lecture_id)
	{
		$uid = Auth::id();
		$tries = TryIt::whereRaw('uid = ? and lecture_id = ?', array($uid, $lecture_id))->orderBy('created_at', 'asc')->get();
		$max = 0;
		foreach ($tries as $t) {
			$score = intval($t->score);
			if ($score > $max) {
				$max = $score;
			}
		}
		return $max;
	}

	public function splitPy($pinyin)
	{
		$pyArray = $this->implode_str($pinyin);
		$result = array();
		if (in_array($pyArray[0], array('c', 's', 'z')) and $pyArray[1] == 'h') {
			$result['first'] = $pyArray[0].$pyArray[1];
			$result['second'] = implode('', array_slice($pyArray, 2));
		} else {
			$result['first'] = $pyArray[0];
			$result['second'] = implode('', array_slice($pyArray, 1));
		}
		return $result;
	}

	public function pinyinTest($pinyin)
	{
		$result = $this->splitPy($pinyin);
		print_r($result);
	}

	public function pyScore($target, $test)
	{
		$targetArray = $this->splitPy($target);
		$testArray = $this->splitPy($test);
		$score = 0;
		if ($targetArray['first'] == $testArray['first']) {
			$score += 2;
		}
		if ($targetArray['second'] == $testArray['second']) {
			$score += 1;
		}
		return $score;
	}

	public function pyScoreMark($target, $test)
	{
		$targetArray = $this->splitPy($target);
		$testArray = $this->splitPy($test);
		$result = array();
		if ($targetArray['first'] == $testArray['first']) {
			$result[] = array('pinyin'=>$testArray['first'], 'right'=>1);
		} else {
			$result[] = array('pinyin'=>$testArray['first'], 'right'=>0);
		}
		if ($targetArray['second'] == $testArray['second']) {
			$result[] = array('pinyin'=>$testArray['second'], 'right'=>1);
		} else {
			$result[] = array('pinyin'=>$testArray['second'], 'right'=>0);
		}
		return $result;
	}

	public function toPY($char)
	{
		$strArray = $this->implode_str($char);
		$pytable = unserialize(file_get_contents('pinyin/pytable_with_tune.txt'));
		$result = array();
		foreach ($strArray as $str) {
			if (isset($pytable[$str])) {
				$result[] = $pytable[$str][0];
			} else {
				// $result[] = 'none';
			}
			
		}
		return $result;
	}		

}
