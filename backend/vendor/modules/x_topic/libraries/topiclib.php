<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/22/13
 * Time: 10:51 AM
 * To change this template use File | Settings | File Templates.
 */
class TopicLib{

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('x_topic/topic_model');
        $this->ci->load->helper('x_topic/topic');
    }
}

class Topic_Exception extends Exception
{
    public function __construct($message, $code = null, $previous = null){
        if ($code === null && $previous === null) {
            parent::__construct($message);
        } elseif ($previous === null && empty($code) === false) {
            parent::__construct($message, $code);
        } else {
            parent::__construct($message, $code, $previous);
        }
    }
}