<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/22/13
 * Time: 1:59 PM
 * To change this template use File | Settings | File Templates.
 */
class MarketplaceHelper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }
}
MarketplaceHelper::init();