<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/19/13
 * Time: 1:08 PM
 * To change this template use File | Settings | File Templates.
 */
class ChallengeBuilderHelper{

    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }
}
ChallengeBuilderHelper::init();
