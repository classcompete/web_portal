<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/6/13
 * Time: 12:37 PM
 */
class Top_student_class extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_reporting/reportlib');
    }

    public function id_get(){
        $data = new stdClass();
        $class_id = $this->get('class');

        $data->top_students = $this->reportlib->get_top_three_students_in_class($class_id);

        $this->response($data);
    }

}