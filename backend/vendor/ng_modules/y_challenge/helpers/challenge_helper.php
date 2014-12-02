<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 23:16
 */
class ChallengeHelper{

    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }
}
ChallengeHelper::init();