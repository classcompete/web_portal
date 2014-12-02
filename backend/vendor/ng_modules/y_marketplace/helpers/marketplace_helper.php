<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 07/11/13
 * Time: 16:46
 */
class MarketplaceHelper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }
}
MarketplaceHelper::init();