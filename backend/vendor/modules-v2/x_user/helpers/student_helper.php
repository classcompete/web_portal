<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/4/14
 * Time: 12:23 PM
 */
class StudentHelper{

    static $ci;

    public static function init(){
        self::$ci = & get_instance();
    }

}
StudentHelper::init();