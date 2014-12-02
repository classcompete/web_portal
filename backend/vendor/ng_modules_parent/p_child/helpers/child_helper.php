<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/20/13
 * Time: 1:54 PM
 */
class Child_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
Child_helper::init();