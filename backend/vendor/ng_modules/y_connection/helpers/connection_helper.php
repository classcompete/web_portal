<?php
class Connection_helper
{
    static $ci;

    public static function init()
    {
        self::$ci = & get_instance();
    }
}

Connection_helper::init();