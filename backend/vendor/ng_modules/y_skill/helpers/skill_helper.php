<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 22:36
 */
class Skill_helper{
    static $ci;

    public static function init(){
        self::$ci = & get_instance();
    }
}
Skill_helper::init();