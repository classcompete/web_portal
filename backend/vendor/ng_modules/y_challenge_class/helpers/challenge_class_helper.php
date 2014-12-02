<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 23:37
 */
class ChallengeClassHelper{

    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
ChallengeClassHelper::init();