<?php
class ParentStudentHelper
{
    static $ci;

    public static function init()
    {
        self::$ci = & get_instance();
    }
}

ParentStudentHelper::init();