<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/22/13
 * Time: 1:46 PM
 * To change this template use File | Settings | File Templates.
 */
class Marketplacelib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_marketplace/marketplace_model');
        $this->ci->load->helper('x_marketplace/marketplace');
    }
}