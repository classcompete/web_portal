<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/19/13
 * Time: 3:21 PM
 * To change this template use File | Settings | File Templates.
 */
class Connectionlib {

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_connection/connection_model');
        $this->ci->load->helper('x_connection/connection');
    }
}
class Connectionlib_Exception extends Exception
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