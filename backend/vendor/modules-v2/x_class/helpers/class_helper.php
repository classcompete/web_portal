<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 6/16/14
 * Time: 1:06 PM
 */
class ClassHelper{

    static $ci;

    public static function init(){
        self::$ci = & get_instance();
    }
}
ClassHelper::init();