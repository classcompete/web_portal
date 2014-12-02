<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/19/13
 * Time: 3:21 PM
 * To change this template use File | Settings | File Templates.
 */
class ConnectionHelper{

    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
ConnectionHelper::init();