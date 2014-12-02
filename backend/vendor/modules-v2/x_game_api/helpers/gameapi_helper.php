<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/14/14
 * Time: 2:16 PM
 */
class GameapiHelper{

    static $ci;

    public static function init(){
        self::$ci = & get_instance();
    }
}
GameapiHelper::init();