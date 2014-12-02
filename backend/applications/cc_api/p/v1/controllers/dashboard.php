<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 10/2/13
 * Time: 1:52 PM
 * To change this template use File | Settings | File Templates.
 */
class Dashboard extends MY_Controller{
    public function __construct(){}

    public function index(){
        $this->load->helper('url');
        $this->load->view('index.php');
    }
}