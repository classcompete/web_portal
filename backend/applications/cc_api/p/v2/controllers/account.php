<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/29/14
 * Time: 12:56 PM
 */
class Account extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');

        if(ParentHelper::isParent() === false){
            $this->response(null,401);
        }
    }

    public function id_get(){

        $userData = $this->parentlib->getParentDataFromHeader();
        $parent = $this->parent_model->getParentByUserId($userData->getUserId());
//        $userData = $this->user_model->getUser($parent->getUserId());

        $respond = array();

        $respond['username'] = $userData->getLogin();
        $respond['firstName'] = $userData->getFirstName();
        $respond['lastName'] = $userData->getLastName();
        $respond['email'] = $userData->getEmail();
        $respond['country'] = $parent->getCountry();
        $respond['postalCode'] = $parent->getPostalCode();
        $this->response($respond, 200);
    }

    public function id_put(){
        $_POST = $this->put();
        $userId = ParentHelper::getUserId();
        $error = array();
        $password = $this->put('password');
        $retypePassword = $this->put('retypePassword');

        if(!empty($password) || !empty($retypePassword)){
            if($this->form_validation->run('parent.edit-profile-with-password') === false){
                if(form_error('username') != ''){
                    $error['username'] = form_error('username');
                }
                if(form_error('firstName') != ''){
                    $error['firstName'] = form_error('firstName');
                }
                if(form_error('lastName') != ''){
                    $error['lastName'] = form_error('lastName');
                }
                if(form_error('email') != ''){
                    $error['email'] = form_error('email');
                }
                if(form_error('password') != ''){
                    $error['password'] = form_error('password');
                }
                if(form_error('retypePassword') != ''){
                    $error['retypePassword'] = form_error('retypePassword');
                }
            }
        }else{
            if($this->form_validation->run('parent.edit-profile') === false){

                if(form_error('username') != ''){
                    $error['username'] = form_error('username');
                }
                if(form_error('firstName') != ''){
                    $error['firstName'] = form_error('firstName');
                }
                if(form_error('lastName') != ''){
                    $error['lastName'] = form_error('lastName');
                }
                if(form_error('email') != ''){
                    $error['email'] = form_error('email');
                }
            }
        }

        // *** check username

        $userDataByUsername = $this->user_model->getUserByUserName($this->put('username'));
        $userDataByEmail = $this->user_model->getUserByEmail($this->put('email'));

        if(!empty($userDataByEmail) && $userDataByEmail->getUserId() != ParentHelper::getUserId()){
            $error['takenEmail'] = 'Email address is already taken!';
        }
        if(!empty($userDataByUsername) && $userDataByUsername->getUserId() != ParentHelper::getUserId()){
            $error['takenUsername'] = 'Username is already taken!';
        }

        if(!empty($error)){
            $this->response($error, 400);
        }


        $newUserData = new stdClass();
        $newUserData->username = $this->put('username');
        if(isset($password) === true && empty($password) === false){
            $newUserData->password = md5($this->put('password'));
        }

        $newUserData->firstName = $this->put('firstName');
        $newUserData->lastName = $this->put('lastName');
        $newUserData->email = $this->put('email');


        $this->user_model->save($newUserData, ParentHelper::getUserId());


        $newParentData = new stdClass();
        $newParentData->country = $this->put('country');
        $newParentData->postalCode = $this->put('postalCode');
        $this->parent_model->save($newParentData, ParentHelper::getUserId());

        $respond = array('message'=>'Account data is updated!');
        $this->response($respond, 200);
    }

    public function intro_put(){

        $updateIntroData = new stdClass();
        $updateIntroData->viewIntro = PropParentPeer::VIEW_INTRO_TRUE;
        $this->parent_model->save($updateIntroData, ParentHelper::getUserId());
    }
}