<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 18:38
 */
class Teacherlib
{

    private $ci;
    private $_autologin_cookie = 'q9Y3AuCEZ8';

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->model('y_user/teacher_model');
        $this->ci->load->helper('y_user/teacher');
        $this->ci->load->library('y_mailer/mailerlib');
    }


    public function _login($username, $password)
    {
        $teacher = $this->ci->teacher_model->get_teacher_by_email_or_username($username);
        if ($teacher === null) {
            throw new Exception('Wrong username/password', 001);
        }
        if (empty($teacher) === true) {
            throw new Exception('Wrong username', 001);
        }
        $encryptedPassword = md5($password);
        if ($encryptedPassword !== $teacher->getPassword()) {
            throw new Exception('Wrong password', 002);
        }
        return $teacher;
    }

    public function check_email($email)
    {
        $teacher = $this->ci->teacher_model->check_teacher_by_email($email);
        if (empty($teacher) === true) {
            throw new Exception('Wrong email address');
        }
        return $teacher;
    }

    public function is_teacher()
    {
        if ($this->ci->session) {
            $data = $this->ci->session->userdata('userdata');
            if (empty($data) === false) {
                return true;
            }
        }

        return false;
    }

    public function is_teacher_rest(){
        $all_headers = getallheaders();

        if(isset($all_headers['X-API-KEY']) || isset($all_headers['x-api-key'])){
            if (isset($all_headers['X-API-KEY']) === true) {
                $auth_code = $all_headers['X-API-KEY'];
            } else {
                $auth_code = $all_headers['x-api-key'];
            }
            //$this->ci->input->get_request_header('X-API-KEY', true);


            if ($auth_code === 'null' || $auth_code === false) return false;
            if ($auth_code !== 'false' || $auth_code !== false) {
                $teacher_data = $this->ci->teacher_model->get_teacher_info_by_auth_code($auth_code);
            }

            if (empty($teacher_data) === false) {
                return true;
            }
        }
        return false;
    }

    public function get_teacher_data_from_header(){
        $all_headers = getallheaders();

        if(isset($all_headers['X-API-KEY'])){
            $auth_code = $all_headers['X-API-KEY'];
            $teacher_data = $this->ci->teacher_model->get_teacher_info_by_auth_code($auth_code);
            return $teacher_data->getPropUser();
        }else {
            $auth_code = $all_headers['x-api-key'];
            $teacher_data = $this->ci->teacher_model->get_teacher_info_by_auth_code($auth_code);
            return $teacher_data->getPropUser();
        }

        return null;

    }

//    public function unset_teacherlogin()
//    {
//
//        $data = $this->ci->session->userdata('userdata');
//        if ($data instanceof PropTeacher) {
//
//        }
//        $this->ci->session->unset_userdata("userdata");
//    }

//    public function unset_autologin()
//    {
//        $token = get_cookie($this->_autologin_cookie);
//        set_cookie(array(
//            'name' => $this->_autologin_cookie,
//            'value' => null,
//            'expire' => -1,
//        ));
//        $this->ci->teacher_token_model->destroy($token, PropTeacherTokenPeer::TYPE_ADMIN_AUTOLOGIN);
//    }

    /**
     * Setter's section
     * */
    public function set_teacherlogin(PropUser $teacher){
        $prop_teacher   = $this->ci->teacher_model->get_teacher_info($teacher->getUserId());
        $auth_code      = $prop_teacher->getAuthCode();
        $data           = new stdClass();

        /*if teacher do not have auth code, set it and save to db */
        if(empty($auth_code) === true){
            $random = substr(str_shuffle($teacher->getPassword()),10,20);
            $id_md5 = md5($prop_teacher->getTeacherId());
            $auth_code = $id_md5.''.$random;

            $data->auth_code = $auth_code;

            $this->ci->teacher_model->save($data,$prop_teacher->getUserId());

        }

        return $auth_code;

    }

//    public function set_autologin(PropUser $user, $time)
//    {
//
//        $token = md5($user->getUsername() . '-' . $this->generatePassword() . '-' . time());
//        set_cookie(array(
//            'name' => $this->_autologin_cookie,
//            'value' => $token,
//            'expire' => $time
//        ));
//        $this->ci->teacher_token_model->save($user, $time, $token, PropTeacherTokenPeer::TYPE_ADMIN_AUTOLOGIN);
//    }

//    public function set_teacher_autologin(PropTeacherToken $teahcer_token)
//    {
//
//        $admin = $this->ci->teacher_model->get_teacher_by_id($teahcer_token->getTeacherId());
//        $this->set_teacherlogin($admin);
//        return $admin;
//    }

    /**
     * Getter's section
     * */
    public function get_autologin_cookie()
    {
        return $this->_autologin_cookie;
    }

    public function encodePassword($text)
    {
        return md5($text);
    }

    public function generatePassword($length = 8, $strength = 124)
    {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    public function reset_password($email)
    {
        $check = $this->ci->teacher_model->check_teacher_by_email($email);

        $password = $this->generatePassword();
        $check->setPassword(md5($password));

        /*
         * Update teacher password
         * */
        $new_data = new stdClass();
        $new_data->password = $check->getPassword();

        $this->ci->teacher_model->save($new_data, $check->getId());

        $data = new stdClass();
        $data->first_name = $check->getFirstName();
        $data->last_name = $check->getLastName();
        $data->email = $check->getEmail();

        if (ENVIRONMENT != 'development') {
            $this->ci->mailerlib->send_mail_to_user(config_item('teacher_url'), $data, $password);
        }
    }

}