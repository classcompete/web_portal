<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/19/13
 * Time: 1:08 PM
 * To change this template use File | Settings | File Templates.
 */
class Challenge_builderlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_challenge_builder/challenge_builder_model');
        $this->ci->load->helper('x_challenge_builder/challenge_builder');
    }

}