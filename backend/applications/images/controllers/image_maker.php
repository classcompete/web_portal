<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/22/13
 * Time: 3:53 PM
 */
class Image_maker extends REST_Controller{
    public function __construct(){
        parent:: __construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        $this->load->library('y_user/studentlib');
        $this->load->library('y_image_crop/image_crop_lib');
    }

    public function index_post(){
        $image  = $this->post('image');

        $config_data    = array(
            'x_axis' =>     intval($this->post('x_axis')),
            'y_axis' =>     intval($this->post('y_axis')),
            'width'  =>     intval($this->post('width')),
            'height' =>     intval($this->post('height')),
            'zoom'   =>     intval($this->post('zoom')),
            'red'    =>     intval($this->post('red')),
            'green'  =>     intval($this->post('green')),
            'blue'   =>     intval($this->post('blue'))
        );
        $cropped_image  =  $this->image_crop_lib->process_image(trim($image),$config_data);

        $new_image = new stdClass();
        $new_image->image = $cropped_image;
        $this->response($new_image);
    }
}