<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::get('/', function()
{
	return View::make('home');
});*/

Route::get('/hello', function()
{
    $url = URL::to('foo');
    echo $url;
    return 'Hello World';
});

Route::get('about', function()
{
  return View::make('about');
});

/*Route::get('login', array('before'=>'guest', function()
{
  return View::make('login');
}));*/

Route::get('login', function()
{
  return View::make('login');
});

Route::post('login', array('before'=>'guest' ,'uses'=>'HomeController@login'));

/*Route::get('home', function()
{
  return View::make('home');
});*/
Route::get('/', array('uses'=>'HomeController@index'))->before('auth');
Route::get('home', array('uses'=>'HomeController@index'))->before('auth');

Route::get('audiotest', function()
{
    return View::make('audio');
});

Route::get('record/{id}', function($id)
{
    $uid = Auth::id();
    $lecture = Lecture::whereRaw('uid = ? and id = ?', array($uid, $id))->first();
    return View::make('record')->with('lecture', $lecture);
});

Route::post('uploadWebm/{lecture_id}', array('uses'=>'HomeController@uploadWebm'));

Route::get('test', function() {
    echo phpinfo();
});

Route::get('toPinyin/{char}', array('uses'=>'HomeController@toPinyin'));

Route::get('learn/{id}', function($id)
{
    $uid = Auth::id();
    $lecture = Lecture::whereRaw('uid = ? and id = ?', array($uid, $id))->first();
    if ($id == 1) {
        $tongueImg = '/img/learning/grape.gif';
    } elseif ($id == 2) {
        $tongueImg = '/img/learning/apple.gif';
    } elseif ($id == 3) {
        $tongueImg = '/img/learning/peach.gif';
    } elseif ($id == 4) {
        $tongueImg = '/img/learning/watermelon.gif';
    } else {
        $tongueImg = '/img/learning/hamigua.gif';
    }
    return View::make('learn')->with('lecture', $lecture)->with('tongueImg', $tongueImg);
});

Route::post('try/{lecture_id}', array('uses'=>'HomeController@tryit'));

Route::get('progress', array('uses'=>'HomeController@progress'));

Route::get('history/{lecture_id}', array('uses'=>'HomeController@history'));

Route::any('wechat', array('uses'=>'WechatController@index'));

Route::get('createmenu', array('uses'=>'WechatController@createMenu'));

Route::get('testopen', function() {
    $filename = time().'.mp4';
    $dir = '/wechat_mp4/';
    Log::info(".{$dir}{$filename}");
    $fp = fopen (".{$dir}{$filename}", 'w');
    fclose($fp);
});

Route::post('/insert-voice-time/{lecture_id}', array('uses'=>'HomeController@insertVoiceTime'));

Route::post('/video_start/{lecture_id}', array('uses'=>'HomeController@updateVideoStart'));

Route::get('/signal/{uid}', array('uses'=>"HomeController@signal"));

Route::post('/upload-video/{lecture_id}', array('uses'=>'HomeController@uploadVideo'));

Route::get('/evaluate/{uid}/{lecture_id}', array('uses'=>'HomeController@evaluate'));

Route::get('/pytest/{pinyin}', array('uses'=>'HomeController@pinyinTest'));

Route::get('learntest/{id}', function($id)
{
    $uid = Auth::id();
    $lecture = Lecture::whereRaw('uid = ? and id = ?', array($uid, $id))->first();
    return View::make('learntest')->with('lecture', $lecture);
});

Route::post('/upload-voice/{lecture_id}', array('uses'=>'HomeController@uploadVoice'));

Route::get('bbs', function() {
    return View::make('bbs');
});