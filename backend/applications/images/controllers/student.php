<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 02/11/13
 * Time: 00:26
 */
class Student extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_user/studentlib');
    }


    public function index_get(){
        $user_id = $this->get('student');
        $content = null;
        if($user_id){
            $image = $this->student_model->get_student_image($user_id);
            $this->output->set_header('Content-type: image/png');
            if($image === null){
                $fp = fopen(X_IMAGES_PATH .'/'.'profile.png','r');
                $image = fread($fp,filesize(X_IMAGES_PATH .'/'.'profile.png'));
            }else{
                $image = stream_get_contents($image);
            }
            $this->output->set_output($image);
        }
    }

}