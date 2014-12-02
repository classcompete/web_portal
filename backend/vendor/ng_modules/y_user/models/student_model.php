<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 18:38
 */
class Student_model extends CI_Model
{


    public function change_password($user_id, $password)
    {
        $sql = "UPDATE users SET users.password = PASSWORD('" . $password . "')
                    WHERE users.user_id = '" . $user_id . "'";

        $this->db->query($sql);
    }

    public function get_student_image($student_id)
    {

        $img = PropStudentQuery::create()->findOneByStudentId($student_id);

        return $img->getAvatarThumbnail();
    }

    public function get_user_id($student_id)
    {

        $student = PropStudentQuery::create()->findOneByStudentId($student_id);

        return $student->getUserId();
    }

    public function get_student_profile($student_id)
    {
        $student = PropStudentQuery::create()
            ->filterByStudentId($student_id)
            ->joinWith('PropStudent.PropUser')->findOne();
        return $student;
    }

    public function getTotalStudents()
    {
        $total_students = PropStudentQuery::create()->count();
        return $total_students;
    }

    public function get_user_by_username($username)
    {
        return PropUserQuery::create()->findOneByLogin($username);
    }

    public function get_student_by_user_id($user_id)
    {
        return PropStudentQuery::create()->findOneByUserId($user_id);
    }

    public function w_student_validation($user_id, $password){
        $sql = "SELECT * FROM users WHERE user_id = ".$user_id ." AND password = PASSWORD('".$password."')";
        $user = $this->db->query($sql)->row();

        return $user;
    }
}