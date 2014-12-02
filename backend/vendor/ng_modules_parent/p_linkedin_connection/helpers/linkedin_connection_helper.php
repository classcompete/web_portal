<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 1:07 PM
 */
class Linkedin_connection_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
Linkedin_connection_helper::init();