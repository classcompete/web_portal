<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 10/29/13
 * Time: 2:41 PM
 */
class Classroom extends REST_Controller{
    public function __construct(){
        parent::__construct();

        $this->load->library('y_class/classlib');
        $this->load->library('form_validation');
        $this->load->model('y_class_student/class_student_model');
    }
    public function index_get(){
        /*
        * get teacher id for filtering
        * */
        $teacher_id = TeacherHelper::getId();

        $data = new stdClass();

        $this->class_model->filterByTeacherId($teacher_id);

        $class_list = $this->class_model->getList();
        $data->class_list = array();
        if (empty($class_list) === false) {
            foreach ($class_list as $k => $v) {
                $data->class_list[$k]['class_id'] = $v->getClassId();
                $data->class_list[$k]['name'] = $v->getName();
                $data->class_list[$k]['class_code'] = $v->getAuthCode();
            }
        }

        $this->response($data,200);
    }

    /** Function to get available classes to install challenge */
    public function available_get(){
        $challenge_id =  intval($this->get('challenge'));
        $out          = new stdClass();

        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $classes = $this->class_model->getList();

        $out->class_list = array();
        foreach($classes as $class=>$val){
            $installed_on_class = $this->class_model->installed_on_class($val->getClassId(), $challenge_id);
            if($installed_on_class === false){
                $out->class_list[$class]['class_id'] = $val->getClassId();
                $out->class_list[$class]['class_name'] = $val->getName();
            }
        }

        if(count($out) === 0){
            $out->installed = 'all';
        }

        $this->response($out);

    }
    public function index_post(){}
    public function index_delete(){}
    public function index_put(){

        $_POST = $this->put();

        $class_id = $this->put('class_id');

        if ($this->form_validation->run('classes') === false) {
            $error = array();

            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run('classes') === false) {
                if (form_error('name') != '')
                    $error['name'] = form_error('name');
                if (form_error('class_code') != '')
                    $error['class_code'] = form_error('class_code');
                $this->response($error,'400');
            } else {
                /**
                 * check for unique class code
                 * */

                $code       = $this->put('class_code');
                $class_id   = $this->put('class_id');

                if(isset($class_id) === true && empty($class_id) === false){
                    $check  = $this->class_model->check_edit_class_code($code, $class_id);
                }else{
                    $check  = $this->class_model->check_class_code($code);
                }

                if($check === true){
                    $error['class_code'] = 'Class code already exist';
                    $this->response($error,'400');
                }
            }
        }

        $class_data = new stdClass();

        $class_data->name       = $this->put('name');
        $class_data->user_id    = TeacherHelper::getUserId();
        $class_data->auth_code  = $this->put('class_code');


        $new_class = $this->class_model->save($class_data, $class_id);

        $out = array();
        $out['name'] = $new_class->getName();
        $out['class_id'] = $new_class->getClassId();
        $out['class_code'] = $new_class->getAuthCode();

        $this->response($out, 200);

    }
}