<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 23:17
 */
class Challengelib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('y_challenge/challenge_model');
        $this->ci->load->helper('y_challenge/challenge');
    }
}