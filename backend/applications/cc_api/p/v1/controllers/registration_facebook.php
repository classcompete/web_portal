<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/22/14
 * Time: 5:56 PM
 */
class Registration_facebook extends REST_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->library('y_user/parentlib');
        $this->load->library('y_mailer/mailerlib');
        $this->load->library('p_facebook_connection/facebook_connection_lib');
        $this->load->library('y_subscriber/subscriberlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_post(){
        $_POST = $this->post();
        $data = new stdClass();

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('first_name', 'First name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last name', 'required|trim');
        $this->form_validation->set_rules('id', 'ID', 'required|trim');

        if($this->form_validation->run() === false){
            if (form_error('first_name') != '') {
                $error['first_name'] = form_error('first_name');
            }
            if (form_error('last_name') != '') {
                $error['last_name'] = form_error('last_name');
            }
            if (form_error('email') != '') {
                $error['email'] = form_error('email');
            }
            if (form_error('id') != '') {
                $error['id'] = form_error('id');
            }
            $this->response($error, 400);
        }

        $data->email = $this->post('email');
        $check = $this->parent_model->get_parent_by_email($data->email);

        if (empty($check) === false) {
            $error['email'] = 'Email address is already taken!';
            $this->response($error, 400);
        }

        $data->facebook_user_id = $this->post('id');
        $data->email = $this->post('email');
        $data->first_name = $this->post('first_name');
        $data->last_name = $this->post('last_name');
        $data->username = $this->post('email');
        $password = $this->parentlib->generatePassword();
        $data->password = md5($password);

        $fp = fopen(X_PARENT_IMAGES_PATH . '/' . 'profile.png', 'r');
        $data->avatar = base64_encode(fread($fp, filesize(X_PARENT_IMAGES_PATH . '/' . 'profile.png')));
        fclose($fp);

        $user = $this->parent_model->save($data);
        $fb_data = new stdClass();
        $fb_data->code = $this->post('id');
        $this->facebook_connection_model->save($fb_data, $user->getPropParentss()->getFirst()->getParentId());

        try {
            $user = $this->parentlib->_login($data->username, $password);
        } catch (Exception $e) {
            $this->response(array($e->getMessage()), 400);
        }

        $auth_data = new stdClass();

        $auth_data->user_data = $this->parentlib->set_parentlogin($user);

        // try to create new subscriber record
        $subscriber = $this->subscriber_model->get_subscriber_by_email($this->post('email'));
        if (empty($subscriber) === true) {
            // make new subscriber
            $subscriberData = new stdClass();
            $subscriberData->email = $this->post('email');
            $this->subscriber_model->save($subscriberData);
        }

        if(ENVIRONMENT != 'development'){
            $this->mailerlib->send_mail_to_new_register_parent($data->email);
        }
        $this->response($auth_data, 200);
    }
}