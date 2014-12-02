<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/24/13
 * Time: 11:50 AM
 * To change this template use File | Settings | File Templates.
 */
class Content_builder extends MY_Controller{

    public function __construct(){
        parent:: __construct();
    }
    public function index(){

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('content_builder/index/' . $uri);
        }

        $data = new stdClass();

        $data->content = $this->prepareView('x_content_builder', 'home', $data);
        $this->load->view(config_item('teacher_template'), $data);
    }
}