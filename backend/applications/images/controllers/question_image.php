<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/22/13
 * Time: 1:35 PM
 */
class Question_image extends REST_Controller{

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
        $this->load->library('y_question/question_lib');

    }

    public function id_get(){
        $question_id = $this->get('question');
        $image = $this->question_model->get_question_image(intval($question_id));
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image['image']));
    }
    public function index_post(){
        $image = $this->pluploadlib->process_upload();
        $out = array(
            'url' => config_item('upload_url') . '/' . $image,
            'image_name' => $image
        );

//        $data = new stdClass();
//
//        $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR. trim($image);
//        $fp = fopen($img_link,'r');
//
//        $data->avatar = base64_encode(fread($fp,filesize($img_link)));
//        $this->teacher_model->save($data, TeacherHelper::getUserId());
//
//        fclose($fp);

        $this->output->set_output(trim($image));
    }

}