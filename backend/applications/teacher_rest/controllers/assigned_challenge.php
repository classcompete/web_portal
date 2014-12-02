<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 00:16
 */

class Assigned_Challenge extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('y_challenge_class/challenge_classlib');
        $this->load->library('y_user/teacherlib');
        $this->load->library('y_challenge_question/challenge_questionlib');
        $this->load->library('y_challenge/challengelib');

    }

    public function index_get(){
        $data = new stdClass();
        $this->challenge_class_model->filterByTeacherId(TeacherHelper::getId());
        $challenges = $this->challenge_class_model->getList();
        $data->challenges = array();
        foreach($challenges as $challenge=>$val){
            $data->challenges[$challenge]['challenge_name'] = $val->getPropChallenge()->getName();
            $challenge_id = $val->getChallengeId();
            $data->challenges[$challenge]['challenge_id'] = $challenge_id;
            $data->challenges[$challenge]['user_id'] = $val->getPropChallenge()->getUserId();
            $data->challenges[$challenge]['author_name'] = $this->teacher_model->get_teacher_name_by_user_id($val->getPropChallenge()->getUserId());
            $data->challenges[$challenge]['uninstall_challenge'] = $val->getChallclassId();
            $data->challenges[$challenge]['description'] = $val->getPropChallenge()->getDescription();
            $data->challenges[$challenge]['teacher_biography'] = $this->teacher_model->get_teacher_biography_by_user_id($val->getPropChallenge()->getUserId());
            $data->challenges[$challenge]['number_of_questions'] = $this->challenge_question_model->get_amount_number_of_questions($challenge_id);
            $data->challenges[$challenge]['class_id'] = $val->getPropClas()->getClassId();
            $data->challenges[$challenge]['teacher_image'] = $this->config->item('images_url').'teacher/'.$val->getPropChallenge()->getUserId();
            if($val->getPropChallenge()->getUserId() === TeacherHelper::getUserId()){
                $data->challenges[$challenge]['edit_challenge'] = $val->getChallengeId();
            }

            // data for tooltip
            $data->challenges[$challenge]['data']['subject_name'] = $val->getPropChallenge()->getPropSubjects()->getName();
            $data->challenges[$challenge]['data']['skill_name'] = $val->getPropChallenge()->getPropSkills()->getName();
            $data->challenges[$challenge]['data']['topic_name'] = $val->getPropChallenge()->getPropTopic()->getName();
            $data->challenges[$challenge]['data']['level'] = $val->getPropChallenge()->getLevel();
            $data->challenges[$challenge]['data']['game_name'] = $val->getPropChallenge()->getPropGames()->getName();
            $data->challenges[$challenge]['data']['class_name'] = $val->getPropClas()->getName();
            $data->challenges[$challenge]['data']['played_times'] = $this->challenge_model->get_challenge_played_times($val->getChallengeId(), $val->getClassId());
            $data->challenges[$challenge]['data']['challenge_id'] = $challenge_id;
        }

        $this->response($data);
    }

    public function id_get(){
        $data = new stdClass();
        $this->challenge_class_model->filterByTeacherId(TeacherHelper::getId());
        $this->challenge_class_model->filterByClassId(intval($this->get('assigned_challenge')));
        $challenges = $this->challenge_class_model->getList();
        $data->challenges = array();
        foreach($challenges as $challenge=>$val){
            $data->challenges[$challenge]['challenge_name'] = $val->getPropChallenge()->getName();
            $challenge_id = $val->getChallengeId();
            $data->challenges[$challenge]['challenge_id'] = $challenge_id;
            $data->challenges[$challenge]['user_id'] = $val->getPropChallenge()->getUserId();
            $data->challenges[$challenge]['author_name'] = $this->challenge_model->get_teacher_name($val->getPropChallenge()->getUserId());
            $data->challenges[$challenge]['uninstall_challenge'] = $val->getChallclassId();
            $data->challenges[$challenge]['description'] = $val->getPropChallenge()->getDescription();
            $data->challenges[$challenge]['teacher_biography'] = $this->teacher_model->get_teacher_biography_by_user_id($val->getPropChallenge()->getUserId());
            $data->challenges[$challenge]['number_of_questions'] = $this->challenge_question_model->get_amount_number_of_questions($challenge_id);
            $data->challenges[$challenge]['class_id'] = $val->getPropClas()->getClassId();
            $data->challenges[$challenge]['teacher_image'] = $this->config->item('images_url').'teacher/'.$val->getPropChallenge()->getUserId();
            if($val->getPropChallenge()->getUserId() === TeacherHelper::getUserId()){
                $data->challenges[$challenge]['edit_challenge'] = $val->getChallengeId();
            }

            // data for tooltip
            $data->challenges[$challenge]['data']['subject_name'] = $val->getPropChallenge()->getPropSubjects()->getName();
            $data->challenges[$challenge]['data']['skill_name'] = $val->getPropChallenge()->getPropSkills()->getName();
            $data->challenges[$challenge]['data']['topic_name'] = $val->getPropChallenge()->getPropTopic()->getName();
            $data->challenges[$challenge]['data']['level'] = $val->getPropChallenge()->getLevel();
            $data->challenges[$challenge]['data']['game_name'] = $val->getPropChallenge()->getPropGames()->getName();
            $data->challenges[$challenge]['data']['class_name'] = $val->getPropClas()->getName();
            $data->challenges[$challenge]['data']['played_times'] = $this->challenge_model->get_challenge_played_times($val->getChallengeId(), $val->getClassId());
            $data->challenges[$challenge]['data']['challenge_id'] = $challenge_id;
        }

        $this->response($data);
    }

    public function single_get(){
        $data = new stdClass();
        $this->challenge_class_model->filterByTeacherId(TeacherHelper::getId());
        $this->challenge_class_model->filterByClassId(intval($this->get('class')));
        $this->challenge_class_model->filterByChallengeId(intval($this->get('challenge')));
        $challenges = $this->challenge_class_model->getList();
        $challenge = $challenges->getFirst();

        $data = new stdClass();
        $data->challenge = array();

        $data->challenge['challenge_name'] = $challenge->getPropChallenge()->getName();
        $challenge_id = $challenge->getChallengeId();
        $data->challenge['challenge_id'] = $challenge_id;
        $data->challenge['user_id'] = $challenge->getPropChallenge()->getUserId();
        $data->challenge['author_name'] = $this->challenge_model->get_teacher_name($challenge->getPropChallenge()->getUserId());
        $data->challenge['uninstall_challenge'] = $challenge->getChallclassId();
        $data->challenge['description'] = $challenge->getPropChallenge()->getDescription();
        $data->challenge['teacher_biography'] = $this->teacher_model->get_teacher_biography_by_user_id($challenge->getPropChallenge()->getUserId());
        $data->challenge['number_of_questions'] = $this->challenge_question_model->get_amount_number_of_questions($challenge_id);
        $data->challenge['class_id'] = $challenge->getPropClas()->getClassId();
        $data->challenge['teacher_image'] = $this->config->item('images_url').'teacher/'.$challenge->getPropChallenge()->getUserId();
        if($challenge->getPropChallenge()->getUserId() === TeacherHelper::getUserId()){
            $data->challenge['edit_challenge'] = $challenge->getChallengeId();
        }

        // data for tooltip
        $data->challenge['data']['subject_name'] = $challenge->getPropChallenge()->getPropSubjects()->getName();
        $data->challenge['data']['skill_name'] = $challenge->getPropChallenge()->getPropSkills()->getName();
        $data->challenge['data']['topic_name'] = $challenge->getPropChallenge()->getPropTopic()->getName();
        $data->challenge['data']['level'] = $challenge->getPropChallenge()->getLevel();
        $data->challenge['data']['game_name'] = $challenge->getPropChallenge()->getPropGames()->getName();
        $data->challenge['data']['class_name'] = $challenge->getPropClas()->getName();
        $data->challenge['data']['played_times'] = $this->challenge_model->get_challenge_played_times($challenge->getChallengeId(), $challenge->getClassId());
        $data->challenge['data']['challenge_id'] = $challenge_id;

        $this->response($data);
    }

    public function index_delete(){
        $status = $this->challenge_class_model->delete_challenge($this->get('challclass'));

        $out = array('deleted'=>true);
        $this->response($out);
    }
} 