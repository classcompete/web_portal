<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/23/13
 * Time: 3:15 PM
 * To change this template use File | Settings | File Templates.
 */
class Teacherlib{

    private $ci;
    private $_autologin_cookie = 'q9Y3AuCEZ8';

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_users/teacher_model');
        $this->ci->load->model('x_users/teacher_token_model');
        $this->ci->load->helper('x_users/teacher');
    }

    public function _login($username,$password){
        $teacher = $this->ci->teacher_model->get_teacher_by_email_or_username($username);
        if($teacher === null){
            throw new Exception('Wrong username/password',001);
        }
        if(empty($teacher) === true){
            throw new Exception('Wrong username',001);
        }
        $encryptedPassword = md5($password);
        if($encryptedPassword !== $teacher->getPassword()){
            throw new Exception('Wrong password',002);
        }
        return $teacher;
    }

    public function check_email($email){
        $teacher = $this->ci->teacher_model->check_teacher_by_email($email);
        if(empty($teacher) === true){
            throw new Exception('Wrong email address');
        }
        return $teacher;
    }

    public function is_teacher(){
        if($this->ci->session){
            $data = $this->ci->session->userdata('userdata');
            if(empty($data) === false){
                return true;
            }
        }
        return false;
    }

    public function is_teacher_rest(){
        $data = $this->ci->input->get_request_header('Auth-token',true);
        $decoded_data = base64_decode($data);
        $object = unserialize($decoded_data);

        if($data !== false){
            $teacher_info = $this->ci->teacher_model->get_teacher_info($object->getUserId());
        }

        if(empty($teacher_info) === false){
            return true;
        }
        return false;
    }
    public function get_teacher_data_from_header(){
        $data = $this->ci->input->get_request_header('Auth-token',true);
        $decoded_data = base64_decode($data);
        $object = unserialize($decoded_data);

        return $object;
    }
    public function unset_teacherlogin(){

        $data = $this->ci->session->userdata('userdata');
        if($data instanceof PropTeacher){

        }
        $this->ci->session->unset_userdata("userdata");
    }

    public function unset_autologin()
    {
        $token = get_cookie($this->_autologin_cookie);
        set_cookie(array(
            'name' => $this->_autologin_cookie,
            'value' => null,
            'expire' => -1,
        ));
        $this->ci->teacher_token_model->destroy($token, PropTeacherTokenPeer::TYPE_ADMIN_AUTOLOGIN);
    }

    /*
    * Setter's section
    * */
    public function set_teacherlogin(PropUser $user){
        $this->ci->session->set_userdata("userdata", $user);

        if($this->ci->session === false){
            NotificationHelper::setNotification(NotificationHelper::$NOTIFICATION_TYPE_WARNING, lang('adminlib.login_failed'));
            delete_cookie($this->_autologoin_cookie);
            redirect('auth/login');
        }
	    $teacher = $this->ci->teacher_model->get_teacher_info($user->getUserId());
		$this->ci->teacher_model->update_teacher_login($teacher);
    }

    public function set_autologin(PropUser $user, $time){
        $token = md5($user->getUsername() . '-' . $this->generatePassword() .'-'.time());
        set_cookie(array(
            'name' => $this->_autologin_cookie,
            'value' => $token,
            'expire' =>$time
        ));
        $this->ci->teacher_token_model->save($user, $time, $token, PropTeacherTokenPeer::TYPE_ADMIN_AUTOLOGIN);
    }

		/**
		 * Auto login teacher by token and return his PropUser object
		 */
    public function set_teacher_autologin(PropTeacherToken $teahcer_token){
        $teacher = $this->ci->teacher_model->get_teacher_by_id($teahcer_token->getTeacherId());
        $this->set_teacherlogin($teacher);
        return $teacher;
    }

    /*
     * Getter's section
     * */
    public function get_autologin_cookie(){
        return $this->_autologin_cookie;
    }
    public function get_teacher_token($token,$type){
        $token = $this->ci->teacher_token_model->get_by_type($token,$type);
        if(empty($token) !== true){
            if(time() > $token->getUpdatedAt('U') + $token->getTtl()){
                $token = null;
            }
        }else{
            $token = null;
        }
        return $token;
    }

		/**
		 * Returns PropUser object for logged teacher from session
		 */
    public function get_teacher_user_from_session(){
        if ($this->ci->session) {
            $user = $this->ci->session->userdata('userdata');
            if(! empty($user)) { return $user; }
        }
        return FALSE;
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

}