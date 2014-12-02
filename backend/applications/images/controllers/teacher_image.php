<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/21/13
 * Time: 5:03 PM
 */
class Teacher_image extends REST_Controller{

    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
         die();
        }
        parent:: __construct();
        $this->load->library('y_plupload/pluploadlib');

    }


    public function index_post(){
        $image = $this->pluploadlib->process_upload();
        $out = array(
            'url' => config_item('upload_url') . '/' . $image,
            'image_name' => $image
        );

        $data = new stdClass();

        $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR. trim($image);
        $fp = fopen($img_link,'r');

        $data->avatar = base64_encode(fread($fp,filesize($img_link)));
        $this->teacher_model->save($data, TeacherHelper::getUserId());

        fclose($fp);

        $this->output->set_output($image);
    }

}