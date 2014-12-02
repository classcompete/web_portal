<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 5/6/14
 * Time: 11:09 AM
 */
class Google_login extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('mailer/mailerlib');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_post(){
        $_POST = $this->post();
        $error = array();
        $code = $this->post('code');

        $googleConn = $this->parent_google_model->getByCode($code);
        if(empty($googleConn)){
            if($this->form_validation->run('parent.signin.google') === false){
                if(form_error('email') != '')$error['email'] = form_error('email');
                if(form_error('firstName') != '')$error['firstName'] = form_error('firstName');
                if(form_error('lastName') != '')$error['lastName'] = form_error('lastName');
                if(form_error('code') != '')$error['code'] = form_error('code');

                $this->response($error, 400);
            }

            // check if we have user with this email
            $check = $this->user_model->getUserByEmail($this->post('email'));

            if(empty($check) === false){
                $error['email'] = 'Email address is already taken!';
                $this->response($error, 400);
            }
            $userData = new stdClass();
            $userData->username = $this->post('email');
            $userData->email = $this->post('email');
            $userData->firstName = $this->post('firstName');
            $userData->lastName = $this->post('lastName');
            $password = $this->userlib->generatePassword();
            $userData->password = md5($password);

            $newUser = $this->user_model->save($userData);

            $parentData = new stdClass();
            $parentData->userId = $newUser->getUserId();
            $parentData->authCode = $this->parentlib->generateAuthCode($newUser);

            $newParent = $this->parent_model->save($parentData);

            $parentFacebookData = new stdClass();
            $parentFacebookData->parentId = $newParent->getParentId();
            $parentFacebookData->googleAuthCode = $this->post('code');
            $newParentFacebook = $this->parent_google_model->save($parentFacebookData);

            $subscriber = $this->subscriber_model->getByEmail($this->post('email'));
            if(empty($subscriber) === true){
                $newSubscriber =  new stdClass();
                $newSubscriber->email = $this->post('email');
                $this->subscriber_model->save($newSubscriber);
            }

            if(ENVIRONMENT != 'development'){
                $emailData = new stdClass();
                $emailData->password = $password;
                $emailData->username = $newUser->getLogin();
                $this->mailerlib->sendAccountCreated($emailData);
            }

            try{
                $user = $this->parentlib->_login($newUser->getLogin(), $password);
            }catch (Exception $e){
                $error['error'] = $e->getMessage();
                $this->response($error, 400);
            }

            $authCode = $this->parentlib->setParentLogin($newUser);

            $respond = new stdClass();
            $respond->data = $authCode;
            $respond->user = 'new';
            $respond->email = $newUser->getEmail();
            $this->response($respond);

        }

        $parent = $this->parent_model->getByParentId($googleConn->getParentId());
        $respond = new stdClass();
        $respond->data = $parent->getAuthCode();
        $respond->user = 'old';
        $respond->email = $parent->getPropUser()->getEmail();
        $this->response($respond, 200);


    }


}