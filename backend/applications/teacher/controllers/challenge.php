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
        $this->load->library('x_challenge_class/challenge_classlib');
        $this->load->library('x_challenge_question/challenge_questionlib');
        $this->load->model('x_users/teacher_model');
        $this->load->library('propellib');
        $this->load->library('form_validation');
        $this->load->model('x_class/class_model');
        $this->load->library('x_reporting/reportlib');
        $this->load->model('x_reporting/report_model');
        $this->load->model('x_challenge_builder/challenge_builder_model');

        $this->propellib->load_object('ChallengeClass');
        $this->mapperlib->set_model($this->challenge_model);

        $this->mapperlib->add_column('name_challenge', 'Challenge name', true);
        $this->mapperlib->add_column('name_subject', 'Subject name', true, 'text','PropSubjects');
        $this->mapperlib->add_column('name_skill', 'Skill name', true, 'text','PropSkill');
        $this->mapperlib->add_column('name_topic', 'Topic name', true, 'text','PropTopic');
        $this->mapperlib->add_column('level', 'Level', true);
        $this->mapperlib->add_column('name_game', 'Game name', true, 'text','PropGames');

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name',
            ),
            'uri' => '#challange/edit',
            'params' => array(
                'id',
            ),
            'data-target' => '#addEditChallenge',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_order_by('name_challenge', 'Challenge name');
        $this->mapperlib->add_order_by('name_subject', 'Subject name');
        $this->mapperlib->add_order_by('name_skill', 'Skill name');
        $this->mapperlib->add_order_by('level', 'level');
        $this->mapperlib->add_order_by('name_game', 'Game name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('challenge/index');

        $this->mapperlib->set_default_order(PropChallengePeer::NAME, Criteria::ASC);

        function sort_by_played_times($a, $b){
            return $b['played_times'] - $a['played_times'];
        }

    }
    public function index(){
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('challenge/index/' . $uri);
        }

        $data = new stdClass();

        $this->challenge_model->setTeacherId(TeacherHelper::getId());
        $challenges = $this->challenge_model->getListForTeacher();
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
            $data->challenges[$challenge]['number_of_questions'] = $this->challenge_builder_model->get_number_of_questions_in_challenge($challenge_id);
            $data->challenges[$challenge]['class_id'] = $val->getPropClas()->getClassId();

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

        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $data->classroms = $this->class_model->getList();

        /** getting data for top 5 challenges */
        $challenges = $this->report_model->get_challenges_created_by_teacher(TeacherHelper::getUserId());
        $top_challenges = array();
        $amount_played_times = 0;
        foreach($challenges as $challenge=>$val){
            $top_challenges[$challenge]['challenge_name'] = $val->getName();
            $top_challenges[$challenge]['challenge_id'] = $val->getChallengeId();
            $played_times = $this->report_model->get_count_of_challenge_played_times($val->getChallengeId());
            $amount_played_times += $played_times;
            $top_challenges[$challenge]['played_times'] = $played_times;

        }
        usort($top_challenges,'sort_by_played_times');
        $top_challenges = array_slice($top_challenges, 0, 5, true);

        foreach($top_challenges as $challenge => $val){
            if($val['played_times'] === 0){
                $top_challenges[$challenge]['played_times_percent'] = 0;
            }else{
                $top_challenges[$challenge]['played_times_percent'] = round(($val['played_times'] / $amount_played_times) * 100,2);;
            }

        }

        $data->top_challenges = $top_challenges;


        $data->content = $this->prepareView('x_challenge', 'home_teacher', $data);
        $this->load->view(config_item('teacher_template'), $data);

    }
    public function save(){

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
        if ($this->input->post('is_read_passage') === 'yes') {
            $challenge->read_title = $this->input->post('read_title');
            $challenge->read_image_url = $this->input->post('read_image_url');
            $challenge->read_text = $this->input->post('read_text');

            $readImageName = $this->input->post('read_image');

            if (empty($readImageName) === false) {
                $imageLink = X_TEACHER_UPLOAD_PATH . '/'. $readImageName;

                $fp = fopen($imageLink,'r');
                $challenge->read_image = base64_encode(fread($fp,filesize($imageLink)));
                fclose($fp);
            }

        } else {
            $challenge->read_title = '';
            $challenge->read_image_url = '';
            $challenge->read_text = '';
        }


        $is_public = $this->input->post('is_public');

        if($is_public === 'yes'){
            $challenge->is_public = PropChallengePeer::IS_PUBLIC_YES;
        }else{
            $challenge->is_public = PropChallengePeer::IS_PUBLIC_NO;
        }

        // do some challenge text cleanup
        if (empty($challenge->read_text) === false) {
            $challenge->read_text = str_replace(array('“','”', '”', '’', '’','”','’'), array('"','"','\'','"','\'','"','\''),$challenge->read_text);
        }

        $ch = $this->challenge_model->save($challenge,$challenge_id);

        $redirect_to_my_challenges = $this->input->post('my_challenges_redirection');
        if (empty($redirect_to_my_challenges) === false && $redirect_to_my_challenges === 'true'){
            redirect('challenge');
        } else {
            redirect('challenge_builder');
        }
    }

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

    private  function get_challenge($challenge_id){
        $challenge = $this->challenge_model->get_challenge_by_id($challenge_id);
        $challenge->subject = $challenge->getPropSubjects()->getName();
            //$challenge->getSubjects()->getName();

        return $challenge;
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

    /*
    * function to display teacher image
    * @params: $user_id
    * @output: image
    * */
    public function display_teacher_image($teacher_id){
        $image = $this->teacher_model->get_teacher_image($teacher_id);
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image['image_thumb']));
    }
    /*
     * Function for uninstall - delete data from challenge_class table
     * @params: $challclass_id
     * */
    public function ajax_uninstall_challenge($challclass_id){
        $status = $this->challenge_model->delete_challenge_from_challenge_class($challclass_id);

        $out = array();
        $out['deleted'] = $status;
        $this->output->set_output(json_encode($out));
    }

    /*
     * Function to delete challenge - delete data from challenge table
     **/

    public function ajax_delete_challenge($challengeId){
//        $challengeId = $this->input->post('challenge_id');
        // check if challenge have questions
        $out = array();
        if($this->challenge_questionlib->haveQuestions($challengeId) === true){
            $out['message'] = "Challenge can't be deleted because it contains questions!";
        }

        $isSafeToDelete = $this->challenge_classlib->safeToDelete($challengeId);
        if($isSafeToDelete === false){
            $out['message'] = "Challenge can't be deleted because it's connected with class!";
        }


        if(empty($out) === true){
            $this->challenge_model->delete($challengeId);
            $out['deleted'] = true;
        }

        $this->output->set_output(json_encode($out));
    }

    /*
     * function to display choice image
     * @params: choice_id
     * @output: image
     * */
    public function display_choice_image($challengeId){

        $imageStream = $this->challenge_model->display_choice_image($challengeId);
        $imageContent = stream_get_contents($imageStream, -1, 0);

        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($imageContent));

    }
}