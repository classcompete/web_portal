<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/6/13
 * Time: 1:22 PM
 */
class Bottom_student_class extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('y_reporting/reportlib');
    }

    public function id_get(){
        $class_id = $this->get('class');
        $data = new stdClass();

        $data->bottom_students = $this->reportlib->get_bottom_three_students_in_class($class_id);

        $this->response($data);
    }
}