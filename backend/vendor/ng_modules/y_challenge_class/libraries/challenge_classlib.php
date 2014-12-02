<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 23:38
 */
class Challenge_classlib{
    private $ci;

    public function __construct(){

        $this->ci = &get_instance();
        $this->ci->load->model('y_challenge_class/challenge_class_model');
        $this->ci->load->helper('y_challenge_class/challenge_class');

    }
}