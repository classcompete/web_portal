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

        $class_id      = intval($this->get('class'));
        $student_id    = intval($this->get('student'));
        $data          = new stdClass();

        $challenges_in_classroom    = $this->report_model->get_student_classrooms($class_id, $student_id);

        $challenges_id_in_classroom = array();

        foreach($challenges_in_classroom as $challenge=>$val){
            $challenges_id_in_classroom[] = intval($val['challenge_id']);
        }


        $score_data = $this->report_model->get_score_data_by_challenge_array_student_id($challenges_id_in_classroom, $student_id);

        $data->stats = array();
        foreach($score_data as $score=>$val){
            $created_date = strtotime($val->getCreated());
            $data->stats[$score]['date'] = date('m/d/Y h:i a', $created_date);

            $challenge_data = $this->challenge_model->get_challenge_by_id($val->getChallengeId());
            $answers_data   = $this->reportlib->get_answer_data_by_score_id($val->getScoreId());

            $data->stats[$score]['challenge_name'] = $challenge_data->getName();
            if($answers_data['correct'] + $answers_data['incorrect'] > 0){
                $data->stats[$score]['percentage'] = round(($answers_data['correct']/($answers_data['correct'] + $answers_data['incorrect']))*100,2);
            }else{
                $data->stats[$score]['percentage'] = 0;
            }

            $data->stats[$score]['correct_answers'] = $answers_data['correct'];
            $data->stats[$score]['incorrect_answers'] = $answers_data['incorrect'];
            $data->stats[$score]['time_on_course'] = $val->getTotalDuration();
            $data->stats[$score]['coins_collected']    = $this->reportlib->get_student_coins_for_challenge($val->getCreated(),$student_id,$val->getChallengeId());
        }

        $this->response($data);
    }

}