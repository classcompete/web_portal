<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/12/13
 * Time: 20:18
 */
class Student_challenge_played_times extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_reporting/reportlib');
    }

    public function id_get(){
        $class_id           = $this->get('class');
        $students_in_class  = $this->report_model->get_students_in_class($class_id);
        $data               = new stdClass();
        $data->students     = array();

        /** @var $user PropUser */
        /** @var $student_data PropStudent */
        foreach($students_in_class as $k=>$v){
            $data->students[$k]['student_id']              = $v->getPropStudent()->getStudentId();
            $data->students[$k]['student_firstname']       = $v->getPropStudent()->getPropUser()->getFirstName();
            $data->students[$k]['student_lastname']        =  $v->getPropStudent()->getPropUser()->getLastName();
            $data->students[$k]['number_of_challenges']    = $this->report_model->count_students_challenges_by_class_id($v->getPropStudent()->getStudentId(),$class_id);
        }

        $this->response($data);
    }

}