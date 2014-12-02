<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/11/13
 * Time: 1:27 PM
 * To change this template use File | Settings | File Templates.
 */
class Classlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_class/class_model');
        $this->ci->load->model('x_users/users_model');
        $this->ci->load->helper('x_class/class');
    }

    public function generatePassword($length = 6, $strength = 124)
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
class Classlib_Exception extends Exception
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