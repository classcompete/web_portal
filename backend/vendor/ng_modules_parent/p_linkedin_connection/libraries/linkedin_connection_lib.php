<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 1:07 PM
 */
class Linkedin_connection_lib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('p_linkedin_connection/linkedin_connection_model');
        $this->ci->load->helper('p_linkedin_connection/linkedin_connection');
    }
}