<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 17:35
 */
class Subject extends REST_Controller{


    public function __construct(){
        parent:: __construct();

        $this->load->library('y_subject/subjectlib');
    }

    public function index_get(){
        $subject_list = $this->subject_model->getList();
        $out = array();

        foreach($subject_list as $subject=>$val){
            $out[$subject] = new stdClass();
            $out[$subject]->subject_id = $val->getSubjectId();
            $out[$subject]->subject_name = $val->getName();
        }
        $this->response($out);
    }

}