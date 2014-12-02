<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 5/14/14
 * Time: 1:07 PM
 */
class Support extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('mailer/mailerlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('','');

        if(!ParentHelper::isParent()){
            $this->response(null,401);
        }
    }

    public function index_post(){

        $_POST = $this->post();
        $error = array();

        if($this->form_validation->run('parent.send-comment') === false){
            if(form_error('name')!='')$error['name'] = form_error('name');
            if(form_error('email')!='')$error['email'] = form_error('email');
            if(form_error('comment')!='')$error['comment'] = form_error('comment');

            $this->response($error, 400);
        }

        $mailData = new stdClass();
        $mailData->name = $this->post('name');
        $mailData->email = $this->post('email');
        $mailData->comment = $this->post('comment');
        $this->mailerlib->sendSupportComment($mailData);

        $this->response(array('ok'=>true), 200);
    }

}