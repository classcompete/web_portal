<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/12/13
 * Time: 19:27
 */
class Challenge_played_times extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_challenge_class/challenge_classlib');
        $this->load->model('y_challenge/challenge_model');

    }

    public function index_get(){
        $data = new stdClass();

        $this->challenge_class_model->filterByTeacherId(TeacherHelper::getId());
        $challenges = $this->challenge_class_model->getList();

        $data->played_times = array();
        foreach($challenges as $challenge=>$val){
            $data->played_times[$challenge]['challenge_name']   = $val->getPropChallenge()->getName();
            $data->played_times[$challenge]['played_times']     = $this->challenge_model->get_challenge_played_times($val->getChallengeId(), $val->getClassId());
            $data->played_times[$challenge]['class_name']      = $val->getPropclas()->getName();
        }

        $this->response($data);
    }

}