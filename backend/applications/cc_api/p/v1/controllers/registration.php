<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/22/14
 * Time: 3:42 PM
 */
class Registration extends REST_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->library('y_user/parentlib');
        $this->load->library('y_subscriber/subscriberlib');
        $this->load->library('y_mailer/mailerlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_post(){
        $_POST = $this->post();
        $error = array();

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('repassword', 'Retype password', 'required|trim|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('first_name', 'First name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last name', 'required|trim');

        if($this->form_validation->run() === false){
            if (form_error('username') != '') {
                $error['username'] = form_error('username');
            }
            if (form_error('first_name') != '') {
                $error['first_name'] = form_error('first_name');
            }
            if (form_error('last_name') != '') {
                $error['last_name'] = form_error('last_name');
            }
            if (form_error('email') != '') {
                $error['email'] = form_error('email');
            }
            if (form_error('password') != '') {
                $error['password'] = form_error('password');
            }
            if (form_error('repassword') != '') {
                $error['repassword'] = form_error('repassword');
            }
            $this->response($error, 400);
        }

        $check_data = array(
            'username'  => $this->post('username'),
            'email'     => $this->post('email')
        );

        $check = $this->parent_model->check_data_for_registration($check_data);

        if ($check->username === false || $check->email === false) {
            if($check->username === false){
                $error['username'] = 'Username is already taken!';
            }
            if($check->email === false){
                $error['email'] = 'Email address is already taken!';
            }
            $this->response($error, 400);
        }

        $data = new stdClass();
        $password = $this->post('password');
        $data->username = $this->post('username');
        $data->password = md5($password);
        $data->email    = $this->post('email');
        $data->first_name = $this->post('first_name');
        $data->last_name = $this->post('last_name');
        $fp = fopen(X_PARENT_IMAGES_PATH . '/' . 'profile.png', 'r');
        $data->avatar = base64_encode(fread($fp, filesize(X_PARENT_IMAGES_PATH . '/' . 'profile.png')));
        fclose($fp);
        $user = $this->parent_model->save($data);

        try {
            $user = $this->parentlib->_login($data->username, $password);
        } catch (Exception $e) {
            $this->response(array($e->getMessage()), 400);
        }

        $auth_data = new stdClass();

        $auth_data->user_data = $this->parentlib->set_parentlogin($user);

        // try to create new subscriber record
        $subscriber = $this->subscriber_model->get_subscriber_by_email($this->input->post('email'));
        if (empty($subscriber) === true) {
            // make new subscriber
            $subscriberData = new stdClass();
            $subscriberData->email = $this->input->post('email');
            $this->subscriber_model->save($subscriberData);
        }

        if(ENVIRONMENT != 'development'){
            $this->mailerlib->send_mail_to_new_register_parent($data->email);
        }

        $this->response($auth_data, 200);
    }

}