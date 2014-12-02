<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/12/13
 * Time: 1:50 PM
 */
class School extends REST_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('y_school/schoollib');
//        var_dump($this->get());die();
    }

    public function index_get(){

        $school = $this->get('school');
        $zip = $this->get('zip_code');

        $query = new stdClass();
        $query->school = $this->school_model->find_school($school, $zip);


        $this->response($query);
    }
}