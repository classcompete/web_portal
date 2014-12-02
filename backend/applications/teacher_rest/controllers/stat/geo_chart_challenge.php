<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/5/13
 * Time: 5:35 PM
 */
class Geo_chart_challenge extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->model('y_challenge/challenge_model');
    }

    public function index_get(){
        $data = new stdClass();

        /** getting data for geo chart running challenges */
        $challenge_list = $this->challenge_model->getList();
        $challenge_list_state = array();
        foreach($challenge_list as $challenge=>$data){
            $state = $this->teacher_model->get_state($data->getUserId());
            if($state !== false){
                if(isset($challenge_list_state[$state->getState()]) === false){
                    $challenge_list_state[$state->getState()] = 0;
                }
                $challenge_list_state[$state->getState()] += 1 ;
            }

        }
        $data->geoChartData = array();
        $data->geoChartData[0] = array('State','Number of challenges');
        foreach($challenge_list_state as $key=>$val){
            $data->geoChartData[] = array($key,$val);
        }

        $this->response($data);
    }

}