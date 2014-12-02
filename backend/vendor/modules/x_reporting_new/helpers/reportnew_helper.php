<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/29/14
 * Time: 1:23 PM
 */
class ReportnewHelper{

    static $ci;
    public static function init(){
        self::$ci = &get_instance();
    }
}
ReportnewHelper::init();