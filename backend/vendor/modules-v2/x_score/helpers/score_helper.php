<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/8/14
 * Time: 1:36 PM
 */
class ScoreHelper{

    static $ci;

    public static function init(){
        self::$ci = & get_instance();
    }
}
ScoreHelper::init();