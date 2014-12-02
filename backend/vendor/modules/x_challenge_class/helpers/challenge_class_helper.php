<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/15/13
 * Time: 10:45 AM
 * To change this template use File | Settings | File Templates.
 */
class ChallengeClassHelper{

    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
ChallengeClassHelper::init();