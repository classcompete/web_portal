<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 22:41
 */
class Skill extends REST_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('y_skill/skilllib');
    }

    /**
     * Get skill by subject id
     * */
    public function index_get(){
        $skills = $this->skill_model->get_skills_by_subject_id($this->get('skill'));

        $out = array();

        foreach($skills as $skill=>$val){
            $out[$skill]  = new stdClass();
            $out[$skill]->skill_id = $val->getSkillId();
            $out[$skill]->skill_name = $val->getName();
        }

        $this->response($out);
    }
}