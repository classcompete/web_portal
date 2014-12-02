<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/1/14
 * Time: 3:10 PM
 */

class Login extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('x_user/parentlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('','');
    }

    public function index_post(){
        $_POST = $this->post();

        $errorData = new stdClass();
        $errorData->error = array();

        $responseData = new stdClass();
        $responseData->data = array();

        if($this->form_validation->run('parent.login') === false){
            $this->response(null,400);
        }

        $username = $this->post('username');
        $password = $this->post('password');

        try{
            $user = $this->parentlib->_login($username, $password);
        }catch (Exception $e){
            $errorData->error = $e->getMessage();
            $this->response($errorData, 400);
        }

        $authCode = $this->parentlib->setParentLogin($user);

        $responseData->data = $authCode;
        $responseData->email = $user->getEmail();
        $responseData->intro = $user->getPropParents()->getFirst()->getViewIntro() === PropParentPeer::VIEW_INTRO_FALSE ? 0:1;
        $this->response($responseData);

    }

}