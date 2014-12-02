<?php
class Subject_helper
{
    static $ci;

    public static function init()
    {
        self::$ci = & get_instance();
    }
}

Subject_helper::init();