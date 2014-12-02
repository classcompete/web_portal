<?php
class Challenge_builderlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('y_challenge_builder/challenge_builder_model');
        $this->ci->load->helper('y_challenge_builder/challenge_builder');
    }
}