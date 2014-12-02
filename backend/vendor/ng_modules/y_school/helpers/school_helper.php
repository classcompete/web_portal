<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/12/13
 * Time: 1:53 PM
 */
class School_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
School_helper::init();