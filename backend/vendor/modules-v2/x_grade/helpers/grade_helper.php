<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/7/14
 * Time: 1:20 PM
 */
class GradeHelper{

    static $ci;

    public static function init(){
        self::$ci = & get_instance();
    }
}
GradeHelper::init();