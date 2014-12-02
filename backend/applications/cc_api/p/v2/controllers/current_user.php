<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/2/14
 * Time: 5:50 PM
 */
class Current_user extends REST_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index_get(){
        $data = array();

        if (ParentHelper::isParent() === true) {
            $data['logged'] = true;
            $data['email'] = ParentHelper::getEmail();
            $this->response($data, 200);
        } else {
            $data['logged'] = false;
            $this->response($data, 401);
        }
    }

}