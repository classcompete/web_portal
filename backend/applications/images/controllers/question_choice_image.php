<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/27/13
 * Time: 7:41 PM
 */
class Question_choice_image extends REST_Controller{

    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent:: __construct();
        $this->load->library('y_plupload/pluploadlib');
        $this->load->library('y_question/question_lib');

    }

    public function id_get(){
        $choice_id = $this->get('choice');
        $image = $this->question_model->display_question_choice_image($choice_id);
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image['image']));
    }
}