<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/12/13
 * Time: 23:31
 */
class Student_class_challenge_average extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_reporting/reportlib');
    }

    public function index_get(){
        $class_id                   = $this->get('class');
        $student_id                 = $this->get("student");
        $challenges_in_classroom    = $this->report_model->get_student_classrooms($class_id, $student_id);
        $data                       = new stdClass();
        $data->average_data         = array();

        foreach($challenges_in_classroom as $k=>$v){
            $answers                        = $this->reportlib->get_student_classrooms_answers($v['challenge_id'], $student_id);
            $data->average_data[$k]['challenge_name']     =  $v['name'];
            $data->average_data[$k]['challenge_id']       =  $v['challenge_id'];
            $data->average_data[$k]['correct_answers']    = $answers['correct'];
            $data->average_data[$k]['incorrect_answers']  = $answers['incorrect'];
            $data->average_data[$k]['total_duration']     = $this->report_model->get_student_classrooms_duration($student_id, $v['challenge_id']);
            $data->average_data[$k]['coins_collected']    = $this->report_model->get_student_coins_by_challenge($student_id,$v['challenge_id']);
        }

        $this->response($data);
    }

}