<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/11/13
 * Time: 7:09 PM
 * To change this template use File | Settings | File Templates.
 */
class ClassStudentHelper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }




}
ClassStudentHelper::init();