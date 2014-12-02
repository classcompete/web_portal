<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 11/06/13
 * Time: 21:36 AM
 * To change this template use File | Settings | File Templates.
 */
class Topic_helper{
    static $ci;

    public static function init(){
        self::$ci = & get_instance();
    }
}
Topic_helper::init();