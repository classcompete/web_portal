<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/4/13
 * Time: 5:09 PM
 */
class Student_challenge_score_global extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_reporting/reportlib');
        $this->load->library('y_reporting_new/reportnewlib');
        $this->load->library('y_challenge/challengelib');
    }

    /**
     * Function for getting global statistic for
     *  1. challenge which student played in class
     *  2. challenge which played in same school as current student
     * Display on front: modal for student in class
     * @params: student_id and class_id
     * @out:
     */
    public function id_get(){
        $class_id   = $this->get('class');
        $student_id = $this->get('student');
        $data = new stdClass();

        $data->head_stats = array();
        $data->head_stats[0]['type'] = 'string';
        $data->head_stats[0]['value'] = 'name';
        $data->head_stats[1]['type'] = 'number';
        $data->head_stats[1]['value'] = 'Student';
        $data->head_stats[2]['type'] = 'number';
        $data->head_stats[2]['value'] = 'Classroom';
        $data->head_stats[3]['type'] = 'number';
        $data->head_stats[3]['value'] = 'USA';

        $this->reportnew_model->filterByStudentId($student_id);
        $this->reportnew_model->filterByClassId($class_id);
        $this->reportnew_model->set_group_by(PropScorePeer::CHALLENGE_ID);
        $scores = $this->reportnew_model->getList();

        $student_challenge_score = $this->reportnew_model->getStudentGlobalScoreChallengeInClass($student_id, $class_id);

        $all_student_in_class_challenge_score = $this->reportnew_model->getAllStudentsGlobalScoreChallengeInClass($class_id);

        $all_student_challenge_score = $this->reportnew_model->getAllStudentGlobalChallengeScore();
        $data->stats = array();
        foreach($scores as $score_key=>$score_val){
            $data->stats[count($data->stats)] = array(
                $score_val->getPropChallenge()->getName(),
                round($student_challenge_score[$score_val->getChallengeId()]['score'],2),
                round($all_student_in_class_challenge_score[$score_val->getChallengeId()]['score'],2),
                round($all_student_challenge_score[$score_val->getChallengeId()]['score'],2)
            );
        }

        $obj = new stdClass();
        $obj->chart_data =  $data;
        $this->response($obj);
    }

}