<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/17/13
 * Time: 11:51 AM
 * To change this template use File | Settings | File Templates.
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