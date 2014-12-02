<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 31/10/13
 * Time: 22:24
 */
class Classroom_code extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_class/classlib');
    }

    public function index_get(){
        $code_status = true;
        while($code_status){
            $code = $this->classlib->generatePassword();
            $code_status = $this->class_model->check_class_code($code);
        }
        $this->setParam('class_code',$code);
        $this->transmit();
    }

}