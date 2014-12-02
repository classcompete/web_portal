<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/20/13
 * Time: 2:38 PM
 */
class Parent_image extends REST_Controller{

    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent:: __construct();
        $this->load->library('y_user/parentlib');
        $this->load->library('y_plupload/pluploadlib');
    }
    public function index_get(){
        $parent_id = intval($this->get('parent'));
        $image = $this->parent_model->get_parent_image($parent_id);
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image));
    }

    public function index_post(){
        $image = $this->pluploadlib->process_upload();
        $out = array(
            'url' => config_item('upload_url') . '/' . $image,
            'image_name' => $image
        );

        $data = new stdClass();
        if($image != null){
            $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR. trim($image);
            $fp = fopen($img_link,'r');

            $data->avatar = base64_encode(fread($fp,filesize($img_link)));
            $a = $this->parent_model->save($data, ParentHelper::getUserId());
            fclose($fp);
        }

        $this->output->set_output($image);
    }
}