<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/10/14
 * Time: 4:43 PM
 */
class ParentHelper{

    static $ci;
    public static function init(){
        self::$ci = &get_instance();
    }
}
ParentHelper::init();