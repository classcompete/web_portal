<?php

class AdminHelper
{
    static $ci;
    public static function init()
    {
        self::$ci = &get_instance();
    }
    public static function get_autologin_token(){
        $ac = self::$ci->adminlib->get_autologin_cookie();

        $token_string = get_cookie($ac);
        if($token_string != false){
            $token = self::$ci->adminlib->get_admin_token($token_string, PropAdminTokenPeer::TYPE_ADMIN_AUTOLOGIN);
            return $token;
        }else{
            return false;
        }
    }
    public static function is_admin(){
        return self::$ci->adminlib->is_admin();
    }
    public static function get_admin_id (){
        $admin_data = self::$ci->session->userdata('userdata');
        if($admin_data instanceof PropAdmin){
            return $admin_data->getId();
        }else{
            return null;
        }
    }
    public static function getTimezoneDiff(){
        return -5;
    }

}
AdminHelper::init();