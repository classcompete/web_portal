<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/12/13
 * Time: 3:58 PM
 * To change this template use File | Settings | File Templates.
 */
class Challenge extends MY_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('x_challenge/challengelib');
        $this->load->library('propellib');

        $this->load->library('form_validation');

        $this->propellib->load_object('Challenge');
        $this->mapperlib->set_model($this->challenge_model);

        $this->mapperlib->add_column('name_challenge', 'Name', true);
        $this->mapperlib->add_column('name_subject', 'Subject', true, 'text','PropSubjects');
        $this->mapperlib->add_column('name_skill', 'Topic', true, 'text','PropSkill');
        $this->mapperlib->add_column('level', 'Grade', true);
        $this->mapperlib->add_column('name_game', 'Environment', true, 'text','PropGames');
        $this->mapperlib->add_column('count_question','Number of question');
        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name',
            ),
            'uri' => '#challange/edit',
            'params' => array(
                'id',
            ),
            'data-target' => '#addEditChallengeAdmin',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_order_by('name_challenge', 'Name');
        $this->mapperlib->add_order_by('name_subject', 'Subject');
        $this->mapperlib->add_order_by('name_skill', 'Topic');
        $this->mapperlib->add_order_by('level', 'level');
        $this->mapperlib->add_order_by('name_game', 'Game name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('challenge/index');
        $this->mapperlib->set_breaking_segment(3);
        $this->mapperlib->set_default_order(PropChallengePeer::NAME, Criteria::ASC);

    }
    public function index(){
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('challenge/index/' . $uri);
        }

        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);
        $data->count_challenges = $this->challenge_model->getFoundRows();

        $data->content = $this->prepareView('x_challenge', 'home', $data);
        $this->load->view(config_item('admin_template'), $data);

    }
    public function save(){
        $this->load->library('form_validation');

        $challenge_id = $this->input->post('id');

        if ($this->form_validation->run('challenge') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $challenge_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }


        $challenge = new stdClass();

        $challenge->name = $this->input->post('challenge_name');
        $challenge->subject_id = $this->input->post('subject_id');
        $challenge->skill_id = $this->input->post('skill_id');
        $challenge->level = $this->input->post('level');
        $challenge->game_id = $this->input->post('game_id');
        $challenge->topic_id = $this->input->post('topic_id');
        $challenge->description = $this->input->post('description');

        $is_public = $this->input->post('is_public');

        if($is_public === 'yes'){
            $challenge->is_public = PropChallengePeer::IS_PUBLIC_YES;
        }else{
            $challenge->is_public = PropChallengePeer::IS_PUBLIC_NO;
        }
        $ch = $this->challenge_model->save($challenge,$challenge_id);

        redirect('challenge');
    }

    /*
     * validation function for save function
     * */

    public function ajax_validation(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('challenge') === false){
            if(form_error('challenge_name') != '')
                $error['challenge_name'] = form_error('challenge_name');
            if(form_error('subject_id') != '')
                $error['subject_id'] = form_error('subject_id');
            if(form_error('skill_id') != '')
                $error['skill_id'] = form_error('skill_id');
            if(form_error('level') != '')
                $error['level'] = form_error('level');
            if(form_error('game_id') != '')
                $error['game_id'] = form_error('game_id');
            if(form_error('game_level_id') != '')
                $error['game_level_id'] = form_error('game_level_id');

            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));

    }

    public function ajax($challange_id){

        $challenge = $this->challenge_model->get_challenge_by_id($challange_id);

        $this->output->set_output(json_encode($challenge));

    }
    public function ajax_get_subject(){
        $subject = $this->challenge_model->get_subject();

        if(empty($subject) === false){
            $out = array();
            foreach($subject as $k=>$s){
                $out[$k]['subject_id'] = $s->getSubjectId();
                $out[$k]['name'] = $s->getName();
            }
        }

        $this->output->set_output(json_encode($out));
    }
    public function ajax_get_skill($subject_id){

        $skill = $this->challenge_model->get_skill($subject_id);

        if(empty($skill) === false){
            $out = array();
            foreach($skill as $k=>$v){
                $out[$k]['skill_id'] = $v->getSkillId();
                $out[$k]['name'] = $v->getName();
            }
        }
        $this->output->set_output(json_encode($out));
    }
    public function ajax_get_topic($skill_id){
        $topic = $this->challenge_model->get_topic($skill_id);

        if(empty($topic) === false){
            $out = array();
            foreach($topic as $k=>$v){
                $out[$k]['topic_id'] = $v->getTopicId();
                $out[$k]['name'] = $v->getName();
            }
        }
        $this->output->set_output(json_encode($out));
    }
    public function ajax_get_game(){
        $game = $this->challenge_model->get_game();

        if(empty($game) === false){
            $out = array();
            foreach($game as $k=>$v){
                $out[$k]['game_id'] = $v->getGameId();
                $out[$k]['name'] = $v->getName();
            }
        }
        $this->output->set_output(json_encode($out));
    }
    public function ajax_get_game_level($game_id){

        $game_level = $this->challenge_model->get_game_level($game_id);

        if(empty($game_level) === false){
            $out = array();
            foreach($game_level as $k=>$v){
                $out[$k]['game_level_id'] = $v->getGameLevelId();
                $out[$k]['name'] = $v->getName();
            }
        }
        $this->output->set_output(json_encode($out));
    }
}