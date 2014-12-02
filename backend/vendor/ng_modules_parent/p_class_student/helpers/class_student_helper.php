<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/20/13
 * Time: 2:58 PM
 */
class Class_student_helper {
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }
}
Class_student_helper::init();