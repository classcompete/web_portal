<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 12:52 PM
 */

class Google_connection_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
Google_connection_helper::init();