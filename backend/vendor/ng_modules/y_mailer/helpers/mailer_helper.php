<?php
class MailerHelper{
    static $ci;

    public static function init(){
        self::$ci = &get_instance();
    }

}
MailerHelper::init();