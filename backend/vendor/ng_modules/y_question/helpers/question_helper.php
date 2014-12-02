<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/15/13
 * Time: 5:03 PM
 */
class Question_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
Question_helper::init();