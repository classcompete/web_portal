<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/4/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */
class Games_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
Games_helper::init();