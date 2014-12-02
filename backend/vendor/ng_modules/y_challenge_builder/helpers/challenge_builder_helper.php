<?php
class ChallengeBuilderHelper{

    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }
}
ChallengeBuilderHelper::init();