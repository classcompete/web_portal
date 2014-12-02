<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 23:25
 */
class ChallengeQuestionHelper
{
    static $ci;
    public static function init()
    {
        self::$ci = &get_instance();
    }

}
ChallengeQuestionHelper::init();