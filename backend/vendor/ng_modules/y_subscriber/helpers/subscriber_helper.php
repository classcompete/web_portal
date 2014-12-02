<?php
class Subscriber_helper
{
    static $ci;

    public static function init()
    {
        self::$ci = & get_instance();
    }
}

Subscriber_helper::init();