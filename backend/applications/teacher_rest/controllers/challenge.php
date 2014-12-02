<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 21:04
 */
class Challenge extends REST_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('y_challenge/challengelib');
        $this->load->library('y_challenge_class/challenge_classlib');
        $this->load->library('y_topic/topiclib');
        $this->load->library('y_game/gamelib');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('','');
    }

    public function index_get(){
        $challenge_id = $this->get('challenge');

        $challenge = $this->challenge_model->get_challenge_by_id($challenge_id);

        $out = new stdClass();

        $out->challenge_id      = $challenge->getChallengeId();
        $out->challenge_name    = $challenge->getName();
        $out->subject_id        = $challenge->getSubjectId();
        $out->skill_id          = $challenge->getSkillId();
        $out->grade_id          = $challenge->getLevel();
        $out->topic_id          = $challenge->getTopicId();
        $out->game_id           = $challenge->getGameId();
        $out->challenge_type    = $this->game_model->get_game_code($challenge->getGameId());

        $out->description = $challenge->getDescription();

        $this->response($out,200);
    }

    /**
     * Function for install challenge on class
     */
    public function index_post(){
        $_POST = $this->post();
        $error = new stdClass();

        if($this->form_validation->run('challenge_install') === false){
            if(form_error('class') != '')
                $error->class = "Select class";
            $this->response($error,400);
        }else{

            $data = new stdClass();

            $data->class_id = $this->post('class');
            $data->challenge_id = $this->post('challenge');

            $this->challenge_class_model->save($data, null);
        }

    }
    public function index_put(){
        $_POST = $this->put();
        $error = array();

        if($this->form_validation->run('edit_challenge') === false){
            if(form_error('challenge_name') != '')
                $error['challenge_name'] = form_error('challenge_name');
            if(form_error('subject_id') != '')
                $error['subject_id'] = form_error('subject_id');
            if(form_error('skill_id') != '')
                $error['skill_id'] = form_error('skill_id');
            if(form_error('topic_id') != '')
                $error['topic_id'] = form_error('topic_id');
            if(form_error('grade_id') != '')
                $error['grade_id'] = form_error('grade_id');
            if(form_error('game_id') != '')
                $error['game_id'] = form_error('game_id');
            $this->response($error,400);
        }else {
            $challenge = new stdClass();
            $challenge_id           = $this->put('challenge_id');
            $challenge->name        = $this->put('challenge_name');
            $challenge->subject_id  = $this->put('subject_id');
            $challenge->skill_id    = $this->put('skill_id');
            $challenge->level       = $this->put('grade_id');
            $challenge->game_id     = $this->put('game_id');
            $challenge->topic_id    = $this->put('topic_id');
            $challenge->description = $this->put('description');

            $ch = $this->challenge_model->save($challenge,$challenge_id);

            $error['validation'] = true;
            $this->response($error,200);
        }

    }
}