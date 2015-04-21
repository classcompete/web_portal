<?php

class StudentHelper{

    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }
}
StudentHelper::init();