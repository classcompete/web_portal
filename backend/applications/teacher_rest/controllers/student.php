<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 10/29/13
 * Time: 3:52 PM
 */
class Student extends REST_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->library('y_class/classlib');
        $this->load->library('y_user/studentlib');
        $this->load->library('form_validation');
        $this->load->library('y_class_student/class_studentlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('','');
    }

    /**
     * Get student in class by class id
     */
    public function index_get(){

        $class_id = $this->get('class');
        $out = array();

        $out['students_count'] = 0;
        $out['students'] = array();

        $students = $this->class_model->get_students_from_class($class_id);

        foreach($students as $k=>$v){
            $out['students_count']++;
            $out['students'][$k]['student_id'] = $v->getPropStudent()->getStudentId();
            $out['students'][$k]['first_name'] = $v->getFirstName();
            $out['students'][$k]['last_name'] = $v->getLastName();
            $out['students'][$k]['last_first_name'] = $v->getFirstName() . ' ' . $v->getLastName();
        }

        $this->response($out);
    }

    /**
     * Get student by student id
     */
    public function id_get(){
        $student_id = $this->get('student');

        $out = array();

        $student_data = $this->student_model->get_student_profile($student_id);

        $out['student_info']['user_id'] = $student_data->getPropUser()->getUserId();
        $out['student_info']['username'] = $student_data->getPropUser()->getLogin();
        $out['student_info']['first_name'] = $student_data->getPropUser()->getFirstName();
        $out['student_info']['last_name'] = $student_data->getPropUser()->getLastName();
        $out['student_info']['student_dob'] = $student_data->getDob();
        $out['student_info']['student_email'] = $student_data->getPropUser()->getEmail();
        $out['student_info']['student_image'] = $this->config->item('images_url').'student/'.$student_id;
        $out['student_info']['parent_email'] = ($student_data->getPropUser()->getPropStudent()->getParentEmail() !== null)?$student_data->getPropUser()->getPropStudent()->getParentEmail():false;

        $this->response($out);
    }

    /**
     * Delete student from class
     */
    public function id_delete(){

        $class_id   = $this->get('class');
        $student_id = $this->get('id');

        $student = $this->class_student_model->delete($class_id,$student_id);


        $this->setParam('deleted',true);
        $this->transmit();
    }

    /**
     * Edit student password
     */

    public function index_put(){

        $_POST = $this->put();
        if(empty($_POST)){
            $_POST['password'] = '';
        }
        $error = array();
        if($this->form_validation->run('student_change_password') === false){
            if(form_error('password') != '')
                $error['password'] = form_error('password');
            if(form_error('re_password') != '')
                $error['re_password'] = form_error('re_password');
            $this->response($error,400);
        }else{
            $user_id = $this->student_model->get_user_id($this->put('id'));
            $password = $this->put('password');
            $this->student_model->change_password($user_id,$password);
        }
    }
}
