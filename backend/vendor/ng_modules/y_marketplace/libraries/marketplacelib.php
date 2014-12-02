<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 07/11/13
 * Time: 16:46
 */
class Marketplacelib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('y_marketplace/marketplace_model');
        $this->ci->load->helper('y_marketplace/marketplace');
    }
}