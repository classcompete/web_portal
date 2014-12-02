<?php

class Adminlib
{
    private $ci;
    private $_autologin_cookie = 'q9Y3AuCEZ8';
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('x_admin/admin_model');
        $this->ci->load->model('x_admin/admin_token_model');
        $this->ci->load->helper('x_admin/admin');
    }

    public function _login($username,$password){
        $admin = $this->ci->admin_model->get_admin_by_email_or_username($username);
        $encryptedPassword = md5($password);

        if(empty($admin) === true || $encryptedPassword !== $admin->getPassword() ){
            throw new Exception('Unknown username and password combination');
        }

        return $admin;
    }
    public function check_email($email){
        $admin = $this->ci->admin_model->check_admin_by_email($email);
        if(empty($admin) === true){
            throw new Exception('Wrong email address');
        }
        return $admin;
    }

    public function is_admin(){
        if($this->ci->session){
            $admindata = $this->ci->session->userdata('userdata');

            if($admindata === false){
                return false;
            }
            if(empty($admindata) === false){
                return true;
            }
        }

        return false;
    }

    public function unset_adminlogin(){
        $userdata = $this->ci->session->userdata('userdata');
        if($userdata instanceof PropAdmin){

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
        $this->ci->admin_token_model->destroy($token, PropAdminTokenPeer::TYPE_ADMIN_AUTOLOGIN);
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

    /*
     * Setter's section
     * */
    public function set_adminlogin(PropAdmin $admin){
        $this->ci->session->set_userdata("userdata",$admin);
        if($this->ci->session === false){
            NotificationHelper::setNotification(NotificationHelper::$NOTIFICATION_TYPE_WARNING, lang('adminlib.login_failed'));
            delete_cookie($this->_autologoin_cookie);
            redirect('auth/login');
        }
        $this->ci->admin_model->update_admin_login($admin);
    }
    public function set_autologin(PropAdmin $admin, $time){
        $token = md5($admin->getUsername() . '-' . $this->generatePassword() .'-'.time());
        set_cookie(array(
            'name' => $this->_autologin_cookie,
            'value' => $token,
            'expire' =>$time
        ));
        $this->ci->admin_token_model->save($admin, $time, $token, PropAdminTokenPeer::TYPE_ADMIN_AUTOLOGIN);
    }
    public function set_admin_autologin(PropAdminToken $admin_token){
        $admin = $this->ci->admin_model->get_admin_by_id($admin_token->getAdminId());
        $this->set_adminlogin($admin);
        return $admin;
    }
    /*
     * Getter's section
     * */
    public function get_autologin_cookie(){
        return $this->_autologin_cookie;
    }
    public function get_admin_token($token,$type){
        $token = $this->ci->admin_token_model->get_by_type($token,$type);
        if(empty($token) !== true){
            if(time() > $token->getUpdatedAt('U') + $token->getTtl()){
                $token = null;
            }
        }else{
            $token = null;
        }
        return $token;
    }

    public function encodePassword($text)
    {
        return md5($text);
    }
}
class Adminlib_Exception extends Exception
{

    public function __construct($message, $code = null, $previous = null)
    {
        if ($code === null && $previous === null) {
            parent::__construct($message);
        } elseif ($previous === null && empty($code) === false) {
            parent::__construct($message, $code);
        } else {
            parent::__construct($message, $code, $previous);
        }

    }

}