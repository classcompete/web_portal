<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/5/13
 * Time: 11:24 AM
 * To change this template use File | Settings | File Templates.
 */
class UsersHelper{

    static $ci;
    public static function init(){
        self::$ci = &get_instance();
    }
}
UsersHelper::init();