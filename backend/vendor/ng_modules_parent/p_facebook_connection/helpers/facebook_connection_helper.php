<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 1:05 PM
 */
class Facebook_connection_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
Facebook_connection_helper::init();