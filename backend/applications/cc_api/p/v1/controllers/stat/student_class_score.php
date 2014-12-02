<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/4/13
 * Time: 3:49 PM
 */
class Student_class_score extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_reporting/reportlib');
        $this->load->library('y_reporting_new/reportnewlib');
        $this->load->library('y_challenge/challengelib');
    }
    public function index_get(){}


    /**
     * Function for getting student statistic in classroom
     * Display on front: modal for student in class
     * @params: student_id and class_id
     * @out:
     */
    public function id_get(){
        $class_id   = $this->get('class');
        $student_id    = intval($this->get('student'));
        $data = new stdClass();

        $this->reportnew_model->filterByStudentId($student_id);
        $this->reportnew_model->filterByClassId($class_id);
//        $this->reportnew_model->set_order_by(PropScorePeer::CREATED);
//        $this->reportnew_model->set_order_by_direction(Criteria::DESC);
        $scores = $this->reportnew_model->getList();

        $data->stats = array();
        foreach($scores as $score=>$score_val){
            $data->stats[$score]['date'] = date('m/d/Y h:i a', strtotime($score_val->getCreated()) - (-1 * ParentHelper::getTimezoneDifference()*60*60));
            $data->stats[$score]['challenge_name'] = $score_val->getPropChallenge()->getName();
            $data->stats[$score]['percentage'] = $score_val->getScoreAverage();
            $data->stats[$score]['correct_answers'] = $score_val->getNumCorrectQuestions();
            $data->stats[$score]['incorrect_answers'] = $score_val->getNumTotalQuestions() - $score_val->getNumCorrectQuestions();
            $data->stats[$score]['time_on_course'] = $score_val->getTotalDuration();
            $data->stats[$score]['coins_collected'] = $score_val->getNumCoins();
        }
        $this->response($data);
    }

}