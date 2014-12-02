<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/5/13
 * Time: 2:40 PM
 */
class Class_amount_statistic extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->model('y_class/class_model');
        $this->load->library('y_reporting/reportlib');

    }

    public function index_get(){
        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $class_statistic = $this->class_model->getList();
        $data = new stdClass();

        if(empty($class_statistic) === false){
            foreach($class_statistic as $class=>$val){
                $data->class_statistic[$class]['class_name'] = $val->getName();
                $data->class_statistic[$class]['class_statistic'] = $this->reportlib->get_amount_statistic_correct_answers($val->getClassId());
            }
        }

        $this->response($data);
    }

}