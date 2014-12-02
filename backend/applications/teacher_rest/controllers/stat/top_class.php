<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/6/13
 * Time: 12:26 PM
 */
class Top_class extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_reporting/reportlib');
        $this->load->model('y_class/class_model');

        function sort_by_played_times($a, $b){
            return $b['played_times'] - $a['played_times'];
        }

        function sort_by_played_times_percent($a, $b){
            return $b['class_statistic'] - $a['class_statistic'];
        }
    }

    public function index_get(){
        /** top 3 class */
        $data = new stdClass();
        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $class_statistic = $this->class_model->getList();


        if(empty($class_statistic) === false){
            foreach($class_statistic as $class=>$val){
                $data->class_statistic[$class]['class_name'] = $val->getName();
                $data->class_statistic[$class]['class_statistic'] = $this->reportlib->get_amount_statistic_correct_answers($val->getClassId());
            }
            if(isset($data->class_statistic) === true){
                usort($data->class_statistic,'sort_by_played_times_percent');
                $data->class_statistic = array_slice($data->class_statistic, 0, 3, true);
            }
        }

        $this->response($data);
    }

}