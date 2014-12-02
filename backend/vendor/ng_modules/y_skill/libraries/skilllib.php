<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 22:37
 */
class Skilllib{

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('y_skill/skill_model');
        $this->ci->load->helper('y_skill/skill');
    }
}