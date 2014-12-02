<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 07/11/13
 * Time: 15:35
 */
class Marketplace extends REST_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('y_marketplace/marketplacelib');
        $this->load->library('y_user/teacherlib');
        $this->load->library('y_challenge_question/challenge_questionlib');
        $this->load->library('y_challenge_class/challenge_classlib');
        $this->load->library('y_challenge/challengelib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('','');
    }

    public function id_get(){

        $grade = $this->get('grade');

        switch($grade){
            case 'pre_k':
                $out = $this->get_challenges(-2);
            break;
            case 'k':
                $out = $this->get_challenges(-1);
            break;
            case 'first':
                $out = $this->get_challenges(1);
            break;
            case 'second':
                $out = $this->get_challenges(2);
            break;
            case 'third':
                $out = $this->get_challenges(3);
            break;
            case 'fourth':
                $out = $this->get_challenges(4);
            break;
            case 'fifth':
                $out = $this->get_challenges(5);
            break;
            case 'sixth':
                $out = $this->get_challenges(6);
            break;
            case 'seventh':
                $out = $this->get_challenges(7);
            break;
            case 'eight':
                $out = $this->get_challenges(8);
            break;
        }
        $this->response($out);
    }

    public function index_post(){
        $_POST = $this->post();
        $error = new stdClass();

        if($this->form_validation->run('marketplace_install') === false){
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

    private function get_challenges($level){

        $this->marketplace_model->set_filter_by_level($level);
        $challenges = $this->marketplace_model->getList();
        $data = new stdClass();
        $data->challenges = array();
        foreach($challenges as $challenge=>$val){
            /** @val PropChallenge */
            $data->challenges[$challenge]['challenge_name'] = $val->getName();
            $data->challenges[$challenge]['challenge_id'] = $val->getChallengeId();
            $data->challenges[$challenge]['subject_name'] = $val->getPropSubjects()->getName();
            $data->challenges[$challenge]['skill_name'] = $val->getPropSkills()->getName();
            if (intval($val->getTopicId() > 0)) {
                $data->challenges[$challenge]['subskill_name'] = $val->getPropTopic()->getName();
            } else {
                $data->challenges[$challenge]['subskill_name'] = null;
            }


            $level = $val->getLevel();

            if($level === -2)$level = 'Pre K';
            else if($level === -1)$level = 'K';

            $data->challenges[$challenge]['level'] = $level;
            $data->challenges[$challenge]['user_id'] = $val->getUserId();
            $data->challenges[$challenge]['teacher_image'] = $this->config->item('images_url').'teacher/'.$val->getUserId();
            $data->challenges[$challenge]['subject_id'] = $val->getSubjectId();

            $data->challenges[$challenge]['game_name'] = $val->getPropGames()->getName();
            $data->challenges[$challenge]['description'] = $val->getDescription();
            $data->challenges[$challenge]['author_name'] = $this->teacher_model->get_teacher_name_by_user_id($val->getUserId());
            $data->challenges[$challenge]['number_of_questions'] = $this->challenge_question_model->get_amount_number_of_questions($val->getChallengeId());
            $data->challenges[$challenge]['teacher_biography'] = $this->teacher_model->get_teacher_biography_by_user_id($val->getUserId());
            $data->challenges[$challenge]['played_times'] = $this->challenge_model->get_challenge_played_times($val->getChallengeId());
        }

        return $data;
    }
}
