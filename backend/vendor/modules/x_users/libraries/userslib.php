<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/5/13
 * Time: 11:24 AM
 * To change this template use File | Settings | File Templates.
 */
class Userslib{
    private $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_users/users_model');
        $this->ci->load->helper('x_users/users');
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
class Userslib_Exception extends Exception
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