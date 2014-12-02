<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 12:41 PM
 */
class Social_network_connections extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('p_google_connection/google_connection_lib');
        $this->load->library('p_facebook_connection/facebook_connection_lib');
        $this->load->library('p_linkedin_connection/linkedin_connection_lib');
    }

    public function index_get(){

        $data = new stdClass();

        $data->social_network = array();

        $google_network = $this->google_connection_model->getList()->getFirst();
        $facebook_network = $this->facebook_connection_model->getList()->getFirst();
        $linkedin_network = $this->linkedin_connection_model->getList()->getFirst();

        $data->social_network['google']['name']  = 'Google';
        $data->social_network['facebook']['name']  = 'Facebook';
        $data->social_network['linkedin']['name']  = 'LinkedIn';
        if(isset($google_network) === true && empty($google_network) === false){
            $data->social_network['google']['added']  = true;
        }else {
            $data->social_network['google']['added']  = false;
        }

        if(isset($facebook_network) === true && empty($facebook_network) === false){
            $data->social_network['facebook']['added']  = true;
        }else {
            $data->social_network['facebook']['added']  = false;
        }

        if(isset($linkedin_network) === true && empty($linkedin_network) === false){
            $data->social_network['linkedin']['added']  = true;
        }else {
            $data->social_network['linkedin']['added']  = false;
        }

        $this->response($data);
    }

    public function index_post(){
        $social_network = $this->post('social');
        $data = new stdClass();
        $data->parent_mail = $this->post('parent_mail');
        $data->code = $this->post('code');

        switch($social_network){
            case 'linkedin':
                $lin = $this->linkedin_connection_model->getList()->getFirst();
                if(empty($lin) === true){
                    $this->linkedin_connection_model->save($data,ParentHelper::getId());
                    $out = new stdClass();
                    $out->added = true;
                }else{
                    $out = new stdClass();
                    $out->added = false;
                    $this->response($out);
                }
                break;
            case 'google':
                $gl = $this->google_connection_model->getList()->getFirst();
                if(empty($gl) === true){
                    $out = new stdClass();
                    $out->added = true;
                    $this->google_connection_model->save($data,ParentHelper::getId());
                }else{
                    $out = new stdClass();
                    $out->added = false;
                    $this->response($out);
                }
                break;
            case 'facebook':
                $fb = $this->facebook_connection_model->getList()->getFirst();
                if(empty($fb) === true){
                    $out = new stdClass();
                    $out->added = true;
                    $this->facebook_connection_model->save($data,ParentHelper::getId());
                }else{
                    $out = new stdClass();
                    $out->added = false;
                    $this->response($out);
                }
                break;
        }

        $this->response($out);
    }

    public function id_delete(){
        $network = $this->get('network');

        switch($network){
            case 'LinkedIn':
                $this->linkedin_connection_model->delete($network,ParentHelper::getId());
                break;
            case 'Google':
                $this->google_connection_model->delete($network,ParentHelper::getId());
                break;
            case 'Facebook':
                $this->facebook_connection_model->delete($network,ParentHelper::getId());
                break;
        }
    }
}