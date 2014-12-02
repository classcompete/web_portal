<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/22/13
 * Time: 10:51 AM
 * To change this template use File | Settings | File Templates.
 */
class Topic_helper{
    static $ci;

    public static function init(){
        self::$ci = & get_instance();
    }
}
Topic_helper::init();