<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 2/4/14
 * Time: 3:06 PM
 */
class TimezoneHelper{
    static $ci;

    public static function init()
    {
        self::$ci = & get_instance();
    }

}

TimezoneHelper::init();