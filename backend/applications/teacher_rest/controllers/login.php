<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 10/29/13
 * Time: 4:23 PM
 */
class Login extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('y_user/teacherlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_post(){
        $_POST = $this->post();
        $error = array();

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if($this->form_validation->run() === false){
           if(form_error('username')!='')
               $error['username'] = form_error('username');
           if(form_error('password')!='')
               $error['password'] = form_error('password');
            $this->response($error,400);
        }

        $username = $this->post('username');
        $password = $this->post('password');

        try{
            $user = $this->teacherlib->_login($username, $password);
        }
        catch(Exception $e){
            $error['redirect'] = $e->getMessage();
            $this->response($error, 400);

        }
        $teacher_auth_code = $this->teacherlib->set_teacherlogin($user);

        $data['user_data'] = $teacher_auth_code;
        $this->response($data,200);
    }

    public function index_get(){
        $data = array();

        if(TeacherHelper::is_teacher_rest() === true){
            $data['logged'] = true;
            $data['teacher_image'] = $this->config->item('images_url').'teacher/'.TeacherHelper::getUserId();
            $this->response($data,200);
        }else{
            $data['logged'] = false;
            $this->response($data,401);
        }
    }

    private function login_validation(){

        $this->load->library('form_validation');

        $error = array();

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run() === false){
            if(form_error('username') != ''){
                $error['username'] = form_error('username');
            }
            if(form_error('password') != ''){
                $error['password'] = form_error('password');
            }
            $this->output->set_status_header('400');

        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            try{
                $user = $this->teacherlib->_login($username, $password);
                $error['validation'] = true;
            }
            catch(Exception $e){
                $error['message'] = $e->getMessage();
            }
        }
        return $error;
    }
}