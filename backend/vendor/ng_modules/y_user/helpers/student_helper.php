<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 18:38
 */
class StudentHelper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
StudentHelper::init();