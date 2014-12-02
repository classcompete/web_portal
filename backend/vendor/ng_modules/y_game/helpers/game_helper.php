<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 21:37
 */
class Game_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
Game_helper::init();