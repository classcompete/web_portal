<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 18:38
 */
class Studentlib
{

    private $ci;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->model('y_user/student_model');
        $this->ci->load->helper('y_user/student');
    }

    public function check_if_student_exists_by_username($username)
    {
        $user = $this->ci->student_model->get_user_by_username($username);

        if (empty($user) === false){
            $student = $this->ci->student_model->get_student_by_user_id($user->getUserId());
            if (empty($student) === false) {
                $out = $student;
            } else {
                $out = false;
            }
        } else {
            $out = false;
        }

        return $out;
    }

    public function check_if_password_belongs_to_username($username, $password)
    {
        $student = $this->ci->student_model->get_user_by_username($username);

        $error = false;

        if ($student === null) {
            $out = false;
            $error = true;
        }
        if (empty($student) === true) {
            $out = false;
            $error = true;
        }

        $verify_student = $this->ci->student_model->w_student_validation($student->getUserId(),$password);

        if (empty($verify_student) === true) {
            $out = false;
            $error = true;
        }

        if ($error === false) {
            $out = true;
        }

        return $out;
    }
}
