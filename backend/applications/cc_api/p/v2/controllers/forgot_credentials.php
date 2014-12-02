<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/29/14
 * Time: 11:45 AM
 */
class Forgot_credentials extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('mailer/mailerlib');
    }

    public function index_post(){
        $email = $this->post('email');
        $respond = array();

        /* Check if we have registered parent with this email  */
        $check = $this->parentlib->getParentByEmail($email);

        if($check != false){

            $newPassword = $this->userlib->generatePassword();

            // *** save new user
            $updateUser = new stdClass();
            $updateUser->password = md5($newPassword);
            $this->user_model->save($updateUser, $check->getUserId());

            // *** send email with new password
            $mailData = new stdClass();
            $mailData->password = $newPassword;
            $mailData->username = $check->getUserName();
            $mailData->email = $check->getEmail();
            $this->mailerlib->sendCredentialsRecovery($mailData);

            $respond['message'] = 'Email was sent to your address with new password!';
            $this->response($respond, 200);
        }else{
            $respond['Email'] = 'Wrong email!';
            $this->response($respond,400);
        }

    }

}