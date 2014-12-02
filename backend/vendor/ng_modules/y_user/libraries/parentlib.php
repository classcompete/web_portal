<?php
class Parentlib
{

    private $ci;

//    private $_autologin_cookie = 'q9Y3AuCEZ8';

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->model('y_user/parent_model');
        $this->ci->load->helper('y_user/parent');
//        $this->ci->load->library('y_mailer/mailerlib');
    }

    public function _login($username, $password)
    {
        $parent = $this->ci->parent_model->get_parent_by_email_or_username($username);
        if ($parent === null) {
            throw new Exception('Wrong username/password', 001);
        }
        if (empty($parent) === true) {
            throw new Exception('Wrong username', 001);
        }
        $encryptedPassword = md5($password);
        if ($encryptedPassword !== $parent->getPassword()) {
            throw new Exception('Wrong password', 002);
        }
        return $parent;
    }

    public function is_parent_rest()
    {
        $all_headers = getallheaders();
        if (isset($all_headers['X-API-KEY']) || isset($all_headers['x-api-key'])) {
            if (isset($all_headers['X-API-KEY']) === true) {
                $auth_code = $all_headers['X-API-KEY'];
            } else {
                $auth_code = $all_headers['x-api-key'];
            }
            //$this->ci->input->get_request_header('X-API-KEY', true);


            if ($auth_code === 'null' || $auth_code === false) return false;
            if ($auth_code !== 'false' || $auth_code !== false) {
                $parent_data = $this->ci->parent_model->get_parent_info_by_auth_code($auth_code);
            }

            if (empty($parent_data) === false) {
                return true;
            }
        }
        return false;
    }

    public function get_parent_data_from_header()
    {
        $all_headers = getallheaders();

        if (isset($all_headers['X-API-KEY'])) {
            $auth_code = $all_headers['X-API-KEY'];
            $parent_data = $this->ci->parent_model->get_parent_info_by_auth_code($auth_code);
            return $parent_data->getPropUser();
        } else {
            $auth_code = $all_headers['x-api-key'];
            $parent_data = $this->ci->parent_model->get_parent_info_by_auth_code($auth_code);
            return $parent_data->getPropUser();
        }

        return null;

    }

    /**
     * Setter's section
     * */
    public function set_parentlogin(PropUser $parent)
    {
        $prop_parent = $this->ci->parent_model->get_parent_info($parent->getUserId());
        $auth_code = $prop_parent->getAuthCode();
        $data = new stdClass();

        /*if teacher do not have auth code, set it and save to db */
        if (empty($auth_code) === true) {
            $random = substr(str_shuffle($parent->getPassword()), 10, 20);
            $id_md5 = md5($prop_parent->getParentId());
            $auth_code = $id_md5 . '' . $random;

            $data->auth_code = $auth_code;

            $this->ci->parent_model->save($data, $prop_parent->getUserId());

        }

        return $auth_code;

    }

    public function check_if_parent_exists_by_email($email)
    {
        $parent = $this->ci->parent_model->get_parent_by_email($email);

        if (empty($parent) === false) {
            $out = $parent;
        } else {
            $out = false;
        }

        return $out;
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