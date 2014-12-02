<?php
class Content_builder extends REST_Controller
{

    public function __construct()
    {
        parent:: __construct();

        $this->load->library('y_challenge/challengelib');
        $this->load->library('y_question/question_lib');
        $this->load->library('y_challenge_builder/challenge_builderlib');
        $this->load->library('y_game/gamelib');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_get()
    {
        $data = new stdClass();

        $this->challenge_builder_model->set_userId(TeacherHelper::getUserId());
        $challenges = $this->challenge_builder_model->getList();
        $data->challenges = array();
        foreach ($challenges as $challenge => $val) {
            $data->challenges[$challenge]['challenge_name'] = $val->getName();
            $data->challenges[$challenge]['challenge_id'] = $val->getChallengeId();
            $data->challenges[$challenge]['user_id'] = $val->getUserId();
            $data->challenges[$challenge]['author_name'] = $this->challenge_builder_model->get_teacher_name($val->getUserId());
            $data->challenges[$challenge]['description'] = $val->getDescription();
            $data->challenges[$challenge]['teacher_biography'] = $this->teacher_model->get_teacher_biography_by_user_id($val->getUserId());
            $data->challenges[$challenge]['teacher_image'] = $this->config->item('images_url') . 'teacher/' . $val->getUserId();

            if ($val->getUserId() === TeacherHelper::getUserId()) {
                $data->challenges[$challenge]['edit_challenge'] = $val->getChallengeId();
            }

            // data for tooltip
            $data->challenges[$challenge]['data']['subject_name'] = $val->getPropSubjects()->getName();
            $data->challenges[$challenge]['data']['skill_name'] = $val->getPropSkills()->getName();
            $data->challenges[$challenge]['data']['topic_name'] = $val->getPropTopic()->getName();

            $level = $val->getLevel();
            if ($level === -2) $level = 'Pre k';
            else if ($level === -1) $level = "K";
            $data->challenges[$challenge]['data']['level'] = $level;
            $data->challenges[$challenge]['data']['game_name'] = $val->getPropGames()->getName();
            $data->challenges[$challenge]['data']['number_of_questions'] = $this->challenge_builder_model->get_number_of_questions_in_challenge($val->getChallengeId());
            $data->challenges[$challenge]['data']['played_times'] = $this->challenge_model->get_challenge_played_times($val->getChallengeId());
        }

        $this->response($data);
    }

    public function single_get()
    {
        $challenge_id = $this->get('challenge');

        $data = new stdClass();

        $challenge = $this->challenge_builder_model->getSingle($challenge_id);

        $data->challenge = array();
        $data->challenge['challenge_name'] = $challenge->getName();
        $data->challenge['challenge_id'] = $challenge->getChallengeId();
        $data->challenge['user_id'] = $challenge->getUserId();
        $data->challenge['author_name'] = $this->challenge_builder_model->get_teacher_name($challenge->getUserId());
        $data->challenge['description'] = $challenge->getDescription();
        $data->challenge['teacher_biography'] = $this->teacher_model->get_teacher_biography_by_user_id($challenge->getUserId());
        $data->challenge['teacher_image'] = $this->config->item('images_url') . 'teacher/' . $challenge->getUserId();

        if ($challenge->getUserId() === TeacherHelper::getUserId()) {
            $data->challenge['edit_challenge'] = $challenge->getChallengeId();
        }

        // data for tooltip
        $data->challenge['data']['subject_name'] = $challenge->getPropSubjects()->getName();
        $data->challenge['data']['skill_name'] = $challenge->getPropSkills()->getName();
        $data->challenge['data']['topic_name'] = $challenge->getPropTopic()->getName();

        $level = $challenge->getLevel();
        if ($level === -2) $level = 'Pre k';
        else if ($level === -1) $level = "K";
        $data->challenge['data']['level'] = $level;
        $data->challenge['data']['game_name'] = $challenge->getPropGames()->getName();
        $data->challenge['data']['number_of_questions'] = $this->challenge_builder_model->get_number_of_questions_in_challenge($challenge->getChallengeId());
        $data->challenge['data']['played_times'] = $this->challenge_model->get_challenge_played_times($challenge->getChallengeId());

        $this->response($data);
    }

    public function index_post(){

        $_POST = $this->post();

        $validation_array_name = $this->question_lib->get_validation_array_name_challenge_question($this->post('question_type'), $this->post('game_code'));

        $question_type = $this->post('question_type');
        $question_type_index = str_replace('question_type_', '', $question_type);
        $error = new stdClass();

        if($this->form_validation->run($validation_array_name) === false){
            $error->error = REST_Form_validation::validation_errors_array();

            if (empty($error->error) === true){
                $error->error = 'Validation config for selected game is missing';
            }

            $this->response($error, 400);
        } else {
            $challenge = new stdClass();
            $challenge->name        = $this->post('challenge_name');
            $challenge->subject_id  = $this->post('subject');
            $challenge->skill_id    = $this->post('skill');
            $challenge->level       = $this->post('grade');
            $game_code              = $this->post('game_code');
            $challenge->game_id     = $this->gamelib->get_game_id_by_code($game_code);
            $challenge->topic_id    = $this->post('topic');
            $challenge->description = $this->post('description');
            $challenge->user_id     = TeacherHelper::getUserId();
            $is_public              = $this->post('marketplace');

            if(isset($is_public) === true && empty($is_public) === false){
                $challenge->is_public = PropChallengePeer::IS_PUBLIC_YES;
            }

            $ch = $this->challenge_model->save($challenge,null);

            $post_object = json_decode(json_encode($_POST), false);


            $qu = $this->question_lib->prepare_and_save($post_object, $ch->getChallengeId());

            //$qu = $this->question_model->save($post_object, $ch->getChallengeId());

            $error->validation = true;
            $error->challenge = $ch->getChallengeId();
            $this->response($error,200);
        }
    }

    private function validate_question_1(){
        $error = array();
        if(form_error('question_type_1_question') != ''){
            $error['question_type_1_question'] = form_error('question_type_1_question');
        }

        if(form_error('question_type_1_correct') != '')
            $error['question_type_1_correct'] = 'Select correct answer';
        if(form_error('question_type_1_answer_1') != '')
            $error['question_type_1_answer'] = form_error('question_type_1_answer_1');
        if(form_error('question_type_1_answer_2') != '')
            $error['question_type_1_answer_2'] = form_error('question_type_1_answer_2');

        return $error;
    }
}