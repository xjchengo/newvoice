<?php

class WechatReply extends Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wechat_replies';

    public static function getLastReply($openid)
    {
    	$reply = self::whereRaw('openid = ?', array($openid))->orderBy('id', 'DESC')->first();
    	return $reply;
    }

}