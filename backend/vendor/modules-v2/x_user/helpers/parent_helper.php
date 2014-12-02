<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/1/14
 * Time: 2:33 PM
 */
class ParentHelper{

    static $ci;

    public static function init(){
        self::$ci = & get_instance();
    }

    public static  function isParent(){
        return self::$ci->parentlib->isParent();
    }

    /**
     * Get parent_id for current parent
     */
    public static function getId(){
        $data = self::$ci->parentlib->getParentDataFromHeader();
        if ($data instanceof PropUser) {
            $parent_info = self::$ci->parent_model->getParentByUserId($data->getUserId());
            return $parent_info->getParentId();
        }
        return null;
    }

    public static function getEmail(){
        $data = self::$ci->parentlib->getParentDataFromHeader();

        return $data->getEmail();
    }

    /**
     * Get user_id for current parent
     */
    public static function getUserId(){
        $data = self::$ci->parentlib->getParentDataFromHeader();
        if ($data instanceof PropUser) {
            return $data->getId();
        }
        return null;
    }

    public static function getTimezoneDifference(){
        $data = self::$ci->parentlib->getParentDataFromHeader();
        if ($data instanceof PropUser) {
            $parent_info = self::$ci->parent_model->getParentInfo($data->getUserId());
            return $parent_info->getTimeDiff();
        }
        return null;
    }
}
ParentHelper::init();