<?php

class Auth extends MY_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->library('form_validation');

        if(AdminHelper::is_admin() === true && $this->uri->segment(2) !== 'process_logout'){
            redirect(base_url());
        }

    }
    public function login(){
        $data = new stdClass();
        $data->form_data = $this->session->flashdata('login_form');
        $_POST = $data->form_data;
        $this->load->view(config_item('admin_template').'_login',$data);
    }
    public function forgot_password(){
        $data = new stdClass();
        $data->form_data = $this->session->flashdata('login_form');
        $_POST = $data->form_data;
        $this->load->view(config_item('admin_template').'_forgot_password',$data);
    }
    public function reset_password(){

        $email = $this->input->post('email');

        $check = array();

        /*
         * Check if we have teacher with that email
         * */
        try{
            $check = $this->adminlib->check_email($email);
        }catch (Exception $e){
            $this->notificationlib->setFailure($e->getMessage());
            redirect('auth/forgot_password');
        }

        if(empty($check) === false){
            $password = $this->adminlib->generatePassword();
            $check->setPassword(md5($password));

            /*
             * Update admin password
             * */
            $new_data = new stdClass();
            $new_data->password = $check->getPassword();

            $this->admin_model->save($new_data, $check->getId());

            $data = new stdClass();
            $data->first_name = $check->getFirstName();
            $data->last_name = $check->getLastName();
            $data->email = $check->getEmail();

            $this->session->set_flashdata('message','Check your email for new password');

            if(ENVIRONMENT != 'development'){
                $this->send_mail_to_user(base_url(),$data,$password);
            }
        }
        redirect('auth/login');
    }

    /*
    *
    * Send e-mail to user when new one is created
    * */
    private function send_mail_to_user($link_to_site,$data,$password){

        $subject = "[INFO CLASSCOMPETE] Admin panel";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>Hi $data->first_name $data->last_name</p>
                    <p>Your password for classcompete admin panel was changed</p>
                    <p>Link to site : $link_to_site</p>
                    <p>New password: <strong>$password</strong></p>";
        @mail($data->email, $subject, $email, $headers);
    }

    public function process_login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $remember_me = (bool)$this->input->post('remember_me');

        try{
            $admin = $this->adminlib->_login($username, $password);
        }
        catch(Exception $e){
            $this->notificationlib->setFailure($e->getMessage());
            redirect('auth/login');
        }
        $this->adminlib->set_adminlogin($admin);

        if($remember_me === true){
            $this->adminlib->set_autologin($admin,86400);
        }

        redirect();
    }
    public function process_logout(){
        $this->adminlib->unset_adminlogin();
        $this->adminlib->unset_autologin();
        redirect();
    }

    /*
    * validation function for save function
    * */

    public function ajax_validation(){

        $error = array();

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('admin_login') === false){
            if(form_error('username') != '')
                $error['username'] = form_error('username');
            if(form_error('password') != '')
                $error['password'] = form_error('password');

            $this->output->set_status_header('400');
        }else {

            try{
                $admin = $this->adminlib->_login($username, $password);
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
            catch(Exception $e){
                $error['custom'] = $e->getMessage();
            }
        }
        $this->output->set_output(json_encode($error));
    }
}