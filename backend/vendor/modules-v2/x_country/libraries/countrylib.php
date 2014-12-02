<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 8/5/14
 * Time: 4:41 PM
 */
class Countrylib {

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('x_country/country_model');
    }
}