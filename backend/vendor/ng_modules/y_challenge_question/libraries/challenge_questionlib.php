<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 23:26
 */
class Challenge_questionlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('y_challenge_question/challenge_question_model');
        $this->ci->load->helper('y_challenge_question/challenge_question');
    }


}