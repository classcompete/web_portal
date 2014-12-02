<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 10/3/13
 * Time: 6:35 PM
 * To change this template use File | Settings | File Templates.
 */
class School_lib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_school/school_model');
        $this->ci->load->helper('x_school/school');
    }
}