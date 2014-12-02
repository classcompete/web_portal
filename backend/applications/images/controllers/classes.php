<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 8/5/14
 * Time: 2:19 PM
 */
class Classes extends REST_Controller {

    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent:: __construct();
        $this->load->library('x_class/classlib');
        $this->load->library('y_plupload/pluploadlib');
    }


    /**
     * return class image
     * @params class_id
     */
    public function id_get($id){

        $class = $this->class_model->getById($id);
        $classDetails = $class->getPropClassDetails()->getFirst();


        $image = stream_get_contents($classDetails->getImage());
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output($image);
    }

}