<?php
class ParentHelper
{

    static $ci;

    public static function init()
    {
        self::$ci = & get_instance();
    }

    public static function is_parent_rest()
    {
        return self::$ci->parentlib->is_parent_rest();
    }


    /**
     * Get parent_id of current teacher
     * */

    public static function getId()
    {
        $data = self::$ci->parentlib->get_parent_data_from_header();
        if ($data instanceof PropUser) {
            $parent_info = self::$ci->parent_model->get_parent_info($data->getUserId());
            return $parent_info->getParentId();
        }
        return null;
    }

    /**
     * Get teachers user_id
     * */
    public static function getUserId()
    {
        $data = self::$ci->parentlib->get_parent_data_from_header();
        if ($data instanceof PropUser) {
            return $data->getId();
        }
        return null;
    }

    public static function getTimezoneDifference(){
        $data = self::$ci->parentlib->get_parent_data_from_header();
        if ($data instanceof PropUser) {
            $parent_info = self::$ci->parent_model->get_parent_info($data->getUserId());
            return $parent_info->getTimeDiff();
        }
        return null;
    }
}

ParentHelper::init();