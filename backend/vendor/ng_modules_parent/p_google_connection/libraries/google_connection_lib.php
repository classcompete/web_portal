<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 12:52 PM
 */
class Google_connection_lib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('p_google_connection/google_connection_model');
        $this->ci->load->helper('p_google_connection/google_connection');
    }
}