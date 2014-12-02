<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 19:15
 */
class ClassStudentHelper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }




}
ClassStudentHelper::init();