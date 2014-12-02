<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 2/5/14
 * Time: 3:24 PM
 */
class Timezone extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('p_timezone/timezonelib');
    }

    public function index_get(){

        $data = array();
        $timezones = $this->timezone_model->getList();

        foreach($timezones as $key=>$timezone){
            $data[$key] = new stdClass();
            $data[$key]->id = $timezone->getId();
            $data[$key]->name = $timezone->getName();
            $data[$key]->difference = $timezone->getDifference();
        }

        $this->response($data);
    }

}