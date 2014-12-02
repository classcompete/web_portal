<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 11/06/13
 * Time: 21:36 AM
 * To change this template use File | Settings | File Templates.
 */
class TopicLib{

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('y_topic/topic_model');
        $this->ci->load->helper('y_topic/topic');
    }
}