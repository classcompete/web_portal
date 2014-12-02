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
        $this->load->library('y_challenge/challengelib');
    }

    /**
     * Function for getting global statistic for
     *  1. challenge which student played in class
     *  2. challenge which played in same school as current student
     *  3. challenge which played in same state as current student
     * Display on front: modal for student in class
     * @params: student_id and class_id
     * @out:
     */
    public function id_get(){
        $data = new stdClass();
        if(TeacherHelper::getSchoolId() != 0){

            $student_id = $this->get('student');
            $class_id   = $this->get('class');

            $challenges_in_classroom    = $this->report_model->get_student_classrooms($class_id, $student_id);

            $data->head_stats = array();
            $data->head_stats[0]['type'] = 'string';
            $data->head_stats[0]['value'] = 'name';
            $data->head_stats[1]['type'] = 'number';
            $data->head_stats[1]['value'] = 'Student Average Score';
            $data->head_stats[2]['type'] = 'number';
            $data->head_stats[2]['value'] = 'School Average Score';
            $data->head_stats[3]['type'] = 'number';
            $data->head_stats[3]['value'] = 'State Average Score';

            $data->stats = array();
            foreach($challenges_in_classroom as $challenge=>$val){

                // check if we have result's in score table
                $scores = $this->report_model->get_score_data_by_challenge_array_student_id($val['challenge_id'], $student_id);
                if($scores->getFirst() != null){
                    $challenge_data = $this->challenge_model->get_challenge_by_id($val['challenge_id']);

                    $data->stats[$challenge]['name'] = $challenge_data->getName();
                    $data->stats[$challenge]['student_stats']  = $this->reportlib->get_students_average_result_for_teacher_challenge($val['challenge_id'], $student_id);
                    $data->stats[$challenge]['school_stats']   = $this->reportlib->get_school_average_result_for_teacher_challenges($val['challenge_id']);
                    $data->stats[$challenge]['state_stats']    = $this->reportlib->get_state_average_result_for_teacher_challenges($val['challenge_id']);
                }
            }

        }else{
            $data->error = "You need to update you school in profile page";
        }

        $obj = new stdClass();
        $obj->chart_data =  $data;
        $this->response($obj);
    }

}