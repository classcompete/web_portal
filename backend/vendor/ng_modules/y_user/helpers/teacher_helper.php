<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 18:38
 */
class TeacherHelper{

    static $ci;
    public static function init(){
        self::$ci = &get_instance();
    }

    public static function is_teacher(){
        return self::$ci->teacherlib->is_teacher();
    }

    public static function is_teacher_rest(){
        return self::$ci->teacherlib->is_teacher_rest();
    }


    /**
     * Get teacher_id of current teacher
     * */

    public static function getId(){
        $data = self::$ci->teacherlib->get_teacher_data_from_header();
        if($data instanceof PropUser){
            $teacher_info = self::$ci->teacher_model->get_teacher_info($data->getUserId());
            return $teacher_info->getTeacherId();
        }
        return null;
    }

    public static function getTimezoneDifference(){
        $data = self::$ci->session->userdata('userdata');
        if($data instanceof PropUser){
            $teacher = PropTeacherQuery::create()->findOneByUserId($data->getId());
            return $teacher->getTimeDiff();
        }else {
            return null;
        }
    }

    /**
     * Get user_id of teacher_id
     * */
    public static function getUserId(){
        $data = self::$ci->teacherlib->get_teacher_data_from_header();
        if($data instanceof PropUser){
            return $data->getId();
        }
        return null;
    }

    public static function getSchoolId(){
        $data = self::$ci->teacherlib->get_teacher_data_from_header();

        if($data instanceof PropUser){
            $teacher = PropTeacherQuery::create()->findOneByUserId($data->getId());
            if($teacher->getSchoolId() !== 0){
                return $teacher->getSchoolId();
            }else {
                return null;
            }

        }else{
            return null;
        }
    }

    public static function getState(){
        $data = self::$ci->teacherlib->get_teacher_data_from_header();

        if($data instanceof PropUser){
            $teacher = PropTeacherQuery::create()->findOneByUserId($data->getId());
            if($teacher->getSchoolId() !== 0){
                return $teacher->getPropSchool()->getState();
            }else {
                return null;
            }

        }else{
            return null;
        }
    }
}
TeacherHelper::init();