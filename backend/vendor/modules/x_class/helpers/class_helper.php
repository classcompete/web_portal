<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/11/13
 * Time: 1:27 PM
 * To change this template use File | Settings | File Templates.
 */
class ClassHelper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }


}
ClassHelper::init();