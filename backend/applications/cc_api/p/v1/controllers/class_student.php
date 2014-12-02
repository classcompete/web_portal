<?php
class Class_student extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('p_class_student/class_studentlib');
    }

    public function id_get(){
        $student_id = intval($this->get('student'));

        $this->class_student_model->filterByStudentId($student_id);

        $data = new stdClass();
        $data->classes = array();

        $classes = $this->class_student_model->getList();

        foreach($classes as $class=>$val){
            $data->classes[$class]['class_name'] = $val->getPropClas()->getName();
            $data->classes[$class]['class_id'] = $val->getClassId();
        }

        $this->response($data);
    }
}