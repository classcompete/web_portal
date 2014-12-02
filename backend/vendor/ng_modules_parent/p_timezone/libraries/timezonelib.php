<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 2/4/14
 * Time: 3:07 PM
 */
class Timezonelib{

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('p_timezone/timezone_model');
        $this->ci->load->helper('p_timezone/timezone');
    }

}