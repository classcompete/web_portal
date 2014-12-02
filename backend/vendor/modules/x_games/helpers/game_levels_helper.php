<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/4/13
 * Time: 6:18 PM
 * To change this template use File | Settings | File Templates.
 */
class Game_levels_helper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
Game_levels_helper::init();