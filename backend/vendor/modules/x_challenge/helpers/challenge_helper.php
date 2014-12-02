<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/12/13
 * Time: 4:11 PM
 * To change this template use File | Settings | File Templates.
 */
class ChallengeHelper{

    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }
}
ChallengeHelper::init();
