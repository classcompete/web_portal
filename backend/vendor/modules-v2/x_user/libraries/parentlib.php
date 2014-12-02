<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/1/14
 * Time: 2:40 PM
 */
class Parentlib {

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('x_user/parent_model');
        $this->ci->load->model('x_user/parent_student_model');
        $this->ci->load->model('x_user/parent_facebook_model');
        $this->ci->load->model('x_user/parent_google_model');
        $this->ci->load->model('x_user/subscriber_model');
        $this->ci->load->helper('x_user/parent');
        $this->ci->load->library('x_user/userlib');
    }

    public function _login($username, $password){
        $user = $this->ci->user_model->getUserByUsername($username);

        if ($user === null) {
            throw new Exception('Wrong username/password', 001);
        }
        $parent = $this->ci->parent_model->getParentByUserId($user->getId());


        if (empty($parent) === true) {
            throw new Exception('Wrong username', 001);
        }
        $encryptedPassword = md5($password);
        if ($encryptedPassword !== $user->getPassword()) {
            throw new Exception('Wrong password', 002);
        }
        return $user;
    }

    public function isParent(){
        $all_headers = getallheaders();
        $all_headers = array_change_key_case($all_headers, CASE_UPPER);

        if (isset($all_headers['X-API-KEY'])) {

            $auth_code = $all_headers['X-API-KEY'];

            if ($auth_code === 'null' || $auth_code === false) return false;
            if ($auth_code !== 'false' || $auth_code !== false) {
                $parent_data = $this->ci->parent_model->getParentByAuthCode($auth_code);
            }

            if (empty($parent_data) === false) {
                return true;
            }
        }
        return false;
    }

    public function getParentDataFromHeader(){
        $all_headers = getallheaders();
        $all_headers = array_change_key_case($all_headers, CASE_UPPER);

        if (isset($all_headers['X-API-KEY']) && empty($all_headers['X-API-KEY']) === false) {
            $auth_code = $all_headers['X-API-KEY'];
            $parent_data = $this->ci->parent_model->getParentByAuthCode($auth_code);
            return $parent_data->getPropUser();
        }

        return false;
    }

    public function setParentLogin(PropUser $user){
        $prop_parent = $this->ci->parent_model->getParentByUserId($user->getUserId());
        $auth_code = $prop_parent->getAuthCode();
        $data = new stdClass();

        /*if parent do not have auth code, set it and save to db */
        if (empty($auth_code) === true) {
            $random = substr(str_shuffle($user->getPassword()), 10, 20);
            $id_md5 = md5($prop_parent->getParentId());
            $auth_code = $id_md5 . '' . $random;

            $data->authCode = $auth_code;

            $this->ci->parent_model->save($data, $user->getUserId());

        }
        return $auth_code;
    }

    public function generateAuthCode(PropUser $user){
        $random = substr(str_shuffle($user->getPassword()),10,20);
        $id_md5 = md5($user->getId());
        $authCode = $id_md5 . '' . $random;

        return $authCode;
    }

    public function getParentByEmail($email){
        $user = $this->ci->user_model->getUserByEmail($email);

        if(empty($user))return false;

        $parent = $this->ci->parent_model->getParentByUserId($user->getId());

        if(empty($parent))return false;

        return $user;
    }
}