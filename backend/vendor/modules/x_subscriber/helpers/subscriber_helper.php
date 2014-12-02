<?php
class SubscriberHelper
{
    static $ci;

    public static function init()
    {
        self::$ci = & get_instance();
    }

}

SubscriberHelper::init();