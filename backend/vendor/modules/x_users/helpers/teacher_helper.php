<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/23/13
 * Time: 3:13 PM
 * To change this template use File | Settings | File Templates.
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

    public static function get_autologin_token(){
        $ac = self::$ci->teacherlib->get_autologin_cookie();
        $token_string = get_cookie($ac);
        $token = self::$ci->teacherlib->get_teacher_token($token_string, PropTeacherTokenPeer::TYPE_TEACHER_AUTOLOGIN);
        return $token;
    }

    /*
     * get teacher_id of current teacher
     * */

    public static function getId(){
        $data = self::$ci->session->userdata('userdata');
        if($data instanceof PropUser){
            $teacher = PropTeacherQuery::create()->findOneByUserId($data->getId());
            return $teacher->getTeacherId();
        }else{
            $data = self::$ci->teacherlib->get_teacher_data_from_header();
            if($data instanceof PropUser){
                $teacher_info = self::$ci->teacher_model->get_teacher_info($data->getUserId());
                return $teacher_info->getTeacherId();
            }
            return null;
        }
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

    /*
     * get user_id of teacher_id
     * */
    public static function getUserId(){
        $data = self::$ci->session->userdata('userdata');

        if($data instanceof PropUser){
           return $data->getId();
        }else{
            $data = self::$ci->teacherlib->get_teacher_data_from_header();
            if($data instanceof PropUser){
               return $data->getId();
            }
            return null;
        }
    }

    public static function getSchoolId(){
        $data = self::$ci->session->userdata('userdata');

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
        $data = self::$ci->session->userdata('userdata');

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

    // *** check if current teacher can create public contests
    public static function isPublisher(){
        $teacher = PropTeacherQuery::create()->findOneByTeacherId(self::getId());

        if($teacher->getPublisher() === PropTeacherPeer::PUBLISHER_PUBLIC){
            return true;
        }
        return false;

    }

    public static function getTotalLicenses(){
        $teacher = PropTeacherQuery::create()->findOneByTeacherId(self::getId());
        return $teacher->getLicenseCount();
    }

    public static function getOccupiedLicenses(){
        $teacher = PropTeacherQuery::create()->findOneByTeacherId(self::getId());
        return $teacher->getOccupiedLicenses();
    }

    public static function getAvailableLicenses(){
        $teacher = PropTeacherQuery::create()->findOneByTeacherId(self::getId());
        return $teacher->getAvailableLicenses();
    }

    public static function viewIntro()
    {
        $teacher = PropTeacherQuery::create()->findOneByTeacherId(self::getId());
        return $teacher->getViewIntro();
    }
}
TeacherHelper::init();