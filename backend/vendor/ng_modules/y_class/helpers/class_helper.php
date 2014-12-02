<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 18:54
 */
class ClassHelper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }


}
ClassHelper::init();