<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 10/3/13
 * Time: 6:35 PM
 * To change this template use File | Settings | File Templates.
 */
class School_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
School_helper::init();