<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/5/13
 * Time: 12:34 PM
 */
class Student_challenge_score_class extends REST_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('y_reporting/reportlib');
        $this->load->model('y_class_student/class_student_model');
        $this->load->model('y_challenge_class/challenge_class_model');
        $this->load->model('y_challenge/challenge_model');
    }


    /**
     * Function for getting all students statistic by challenges in specific class
     * Display on front: modal for class (classes page)
     * @params: class_id
     * @out:
     */
    public function id_get(){
        $class_id = intval($this->get('class'));
        $student_stats = array();
        $data = new stdClass();

        $students_in_class = $this->class_student_model->get_students_in_class($class_id);
        $challenges_in_class = $this->challenge_class_model->get_challenges_id_by_class($class_id);

        if($challenges_in_class->getFirst() !== null && $students_in_class->getFirst() !== null){
            $data->head_stats = array();
            $data->stats      = array();

            $data->head_stats[0]['type'] = 'string';
            $data->head_stats[0]['value'] = 'name';

            foreach($challenges_in_class as $challenge=>$val){
                $data->head_stats[$challenge + 1]['type'] = 'number';
                $data->head_stats[$challenge + 1]['value'] = $this->challenge_model->get_challenge_name($val->getChallengeId());
            }
            foreach($students_in_class as $student=>$val){
                $student_stats[] = $val->getPropStudent()->getPropUser()->getFirstName() . ' '.$val->getPropStudent()->getPropUser()->getLastName();
                foreach($challenges_in_class as $challenge){
                    $student_stats[] =  $this->reportlib->get_students_average_result_for_teacher_challenge($challenge->getChallengeId(), $val->getStudentId());
                }
                $data->stats[count($data->stats)] = $student_stats;
                unset($student_stats);
            }

        }else{
            $data->error = 'This class has no corresponding data';
        }

        $response_obj = new stdClass();
        $response_obj->chart_data =  $data;
        $this->response($response_obj);
    }
}