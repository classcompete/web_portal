<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/10/13
 * Time: 10:56 AM
 * To change this template use File | Settings | File Templates.
 */
class ReportHelper{

    static $ci;
    public static function init(){
        self::$ci = &get_instance();
    }
}
ReportHelper::init();