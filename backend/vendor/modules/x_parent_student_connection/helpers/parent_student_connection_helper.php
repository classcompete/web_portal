<?php
class ParentStudentConnectionHelper
{

    static $ci;

    public static function init()
    {
        self::$ci = & get_instance();
    }

}

ParentStudentConnectionHelper::init();