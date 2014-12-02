<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/12/13
 * Time: 22:13
 */
class Student_challenge_played_times_details extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_reporting/reportlib');
    }

    public function index_get(){
        $class_id       = $this->get('class');
        $student_id        = $this->get('student');
        $data           = new stdClass();
        $challenges     = $this->report_model->get_student_challenges_by_class_id($class_id, $student_id);

        $data->challenges = array();
        foreach($challenges as $k=>$v){
            $data->challenges[$k]['challenge_name'] =  $v['name'];
            $data->challenges[$k]['number_of_played_times'] = $this->report_model->count_students_challenge_played_times($student_id, $v['challenge_id']);
        }

        $this->response($data);
    }

}