<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 02/11/13
 * Time: 00:26
 */
class Teacher extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_user/teacherlib');
    }
    public function index_get(){
        $teacher_id = intval($this->get('teacher'));
        $image = $this->teacher_model->get_teacher_image($teacher_id);
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image));
    }
}