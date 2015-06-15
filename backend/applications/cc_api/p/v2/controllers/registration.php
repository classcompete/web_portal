<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/1/14
 * Time: 4:10 PM
 */
error_reporting(E_ALL);
class Registration extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('x_user/parentlib');
        $this->load->library('mailer/mailerlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('','');
    }

    public function index_post(){
        $_POST = $this->post();
        $errorData = array();

        $responseData = new stdClass();
        $responseData->data = array();

        if($this->form_validation->run('parent.registration') === false){
            $this->response('All fields are mandatory', 400);
        }

        $email = $this->post('email');
        $username = $this->post('email');

        // *** check if email is unique
        $uniqueEmail = $this->userlib->isUniqueEmail($email);

        if($uniqueEmail === false){
            $errorData['email'] = 'Email is already taken!';
            $this->response($errorData, 400);
        }

        // *** check if username is unique
        $uniqueUsername = $this->userlib->isUniqueUsername($username);

        if($uniqueUsername === false){
            $errorData['username'] = 'Username is already taken!';
            $this->response($errorData, 400);
        }


        // *** save user data
        $newUserData = new stdClass();

        $newUserData->username = $username;
        $newUserData->email = $email;
        $newUserData->firstName = $this->post('firstName');
        $newUserData->lastName = $this->post('lastName');
        $newUserData->password = md5($this->post('password'));

        $newParentUserData = $this->user_model->save($newUserData);

        // *** save parent data
        $newParentData = new stdClass();

        $newParentData->userId = $newParentUserData->getUserId();
        $newParentData->country = $this->post('country');
        $newParentData->postalCode = $this->post('postalCode');
        $newParent = $this->parent_model->save($newParentData);


        $authCode = $this->parentlib->setParentLogin($newParentUserData);

        $mailData = new stdClass();
        $mailData->password = $this->post('password');
        $mailData->email = $this->post('email');
        $mailData->username = $this->post('email');
        $this->mailerlib->sendAccountCreated($mailData);

        $responseData->data = $authCode;
        $responseData->email = $newParentUserData->getEmail();

        //add to mailchimp
        $this->load->library('mailchimp/mailchimplib');
        $this->mailchimplib->call('lists/subscribe', array(
            'id' => 'a93db0cb9c',
            'email' => array(
                'email' => $newUserData->email
            ),
            'merge_vars' => array(
                'FNAME' => $newUserData->firstName,
                'LNAME' => $newUserData->lastName
            ),
            'double_optin' => false,
            'update_existing' => true,
            'replace_interests' => false,
            'send_welcome' => false,
        ));

        $this->response($responseData);

    }

    public function wp_post()
    {
        $_POST = $this->post();
        $errorData = array();

        $responseData = new stdClass();

        $email = $this->post('email');
        $username = $this->post('email');

        // *** check if email is unique
        $uniqueEmail = $this->userlib->isUniqueEmail($email);

        if($uniqueEmail === false){
            $user = PropUserQuery::create()->findOneByEmail($email);
            $parent = PropParentQuery::create()->findOneByUserId($user->getId());
            if (empty($parent) === false) {
                $responseData->id = $parent->getParentId();
                $responseData->email = $user->getEmail();
                $this->response($responseData, 200);
            }

        }


        // *** check if username is unique
        $uniqueUsername = $this->userlib->isUniqueUsername($username);

        if($uniqueUsername === false){
            $errorData['username'] = 'Username is already taken!';
            $this->response($errorData, 400);
        }


        // *** save user data
        $newUserData = new stdClass();

        $newUserData->username = $username;
        $newUserData->email = $email;
        $newUserData->firstName = $this->post('firstName');
        $newUserData->lastName = $this->post('lastName');
        $newUserData->password = md5($this->post('password'));

        $newParentUserData = $this->user_model->save($newUserData);

        // *** save parent data
        $newParentData = new stdClass();

        $newParentData->userId = $newParentUserData->getUserId();
        $newParentData->country = $this->post('country');
        $newParentData->postalCode = $this->post('postalCode');
        $newParent = $this->parent_model->save($newParentData);


        $authCode = $this->parentlib->setParentLogin($newParentUserData);

        $mailData = new stdClass();
        $mailData->password = $this->post('password');
        $mailData->email = $this->post('email');
        $mailData->username = $this->post('username');
        $this->mailerlib->sendAccountCreated($mailData);

        $responseData->id = $newParent->getParentId();
        $responseData->email = $newParentUserData->getEmail();
        $this->response($responseData);
    }

}