<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/8/14
 * Time: 1:36 PM
 */
class Scorelib {

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('x_score/score_model');
        $this->ci->load->helper('x_score/score');
    }

    public function getClassScoreByChallengeAndClass($challengeId, $scoreId){

    }
}