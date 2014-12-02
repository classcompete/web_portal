<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 2/5/14
 * Time: 2:33 PM
 */
class Password_recovery extends REST_Controller{


    public function __construct(){
        parent::__construct();
        $this->load->library('y_mailer/mailerlib');
    }

    public function index_post(){
        $email = $this->post('email');
        $out = new stdClass();
        $out->error = array();
        $check = array();
        /*
         * Check if we have Parent with that email
         * */
        $parent = $this->parentlib->check_if_parent_exists_by_email($email);

        if($parent === false){
            $out->eror['email'] = 'Wrong email address';
            $this->response($out, 404);
        }

        if(empty($parent) === false){
            $password = $this->parentlib->generatePassword();
            $parent->setPassword(md5($password));

            /*
             * Update parent password
             * */
            $new_data = new stdClass();
            $new_data->password = $parent->getPassword();

            $this->parent_model->save($new_data, $parent->getId());

            $data = new stdClass();
            $data->email = $parent->getEmail();


            $res_out = new stdClass();
            $res_out->message = 'Check your email for new password';

            if(ENVIRONMENT != 'development'){
                $this->mailerlib->send_mail_to_parent_forgot_password($data,$password);
            }

            $this->response($res_out, 200);
        }
    }

}