<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/7/14
 * Time: 2:32 PM
 */
class Userlib {

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('x_user/user_model');
    }

    public function isUniqueUsername($username){
        $user = $this->ci->user_model->getUserByUserName($username);
        return empty($user) ? true : false;
    }

    public function isUniqueEmail($email){
        $user = $this->ci->user_model->getUserByEmail($email);
        return empty($user) ? true : false;
    }
    public function generatePassword($length = 8, $strength = 124){
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