<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/24/13
 * Time: 11:50 AM
 * To change this template use File | Settings | File Templates.
 */
class Marketplace extends MY_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('x_marketplace/marketplacelib');
        $this->load->library('propellib');
        $this->propellib->load_object('Challenge');
        $this->load->library('form_validation');
        $this->load->model('x_challenge/challenge_model');
        $this->load->model('x_challenge_builder/challenge_builder_model');
        $this->load->model('x_users/teacher_model');
    }
    public function index(){

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('marketplace/index/' . $uri);
        }

        $data = new stdClass();

//        $data->grade_1      = $this->get_challenges(-2); //pre_k
//        $data->grade_2      = $this->get_challenges(-1); //k
//        $data->grade_3      = $this->get_challenges(1);
//        $data->grade_4      = $this->get_challenges(2);
//        $data->grade_5      = $this->get_challenges(3);
//        $data->grade_6      = $this->get_challenges(4);
//        $data->grade_7      = $this->get_challenges(5);
//        $data->grade_8      = $this->get_challenges(6);
//        $data->grade_9      = $this->get_challenges(7);
//        $data->grade_10     = $this->get_challenges(8);
        $data->grade_all = $this->get_challenges();

        $data->subjects = $this->get_subject();
        $data->skills = $this->get_skill();
        $data->content = $this->prepareView('x_marketplace', 'home', $data);
        $this->load->view(config_item('teacher_template'), $data);
    }

    private function get_challenges($level = null){

        if (empty($level) === false){
            $this->marketplace_model->set_filter_by_level($level);
        }
        $challenges = $this->marketplace_model->getList();

        $out = array();
        foreach($challenges as $challenge=>$val){
                /** @val PropChallenge */
                $out[$challenge]['challenge_name'] = $val->getName();
                $out[$challenge]['challenge_id'] = $val->getChallengeId();
                $out[$challenge]['subject_name'] = $val->getPropSubjects()->getName();
                $out[$challenge]['skill_name'] = $val->getPropSkills()->getName();
                $out[$challenge]['skill_id'] = $val->getSkillId();
                if (intval($val->getTopicId() > 0)) {
                    $out[$challenge]['subskill_name'] = $val->getPropTopic()->getName();
                } else {
                    $out[$challenge]['subskill_name'] = null;
                }


                $level = $val->getLevel();

                if($level === -2)$level = 'Pre K';
                else if($level === -1)$level = 'K';

                $out[$challenge]['level'] = $level;
                $out[$challenge]['user_id'] = $val->getUserId();
                $out[$challenge]['subject_id'] = $val->getSubjectId();

                $out[$challenge]['game_name'] = $val->getPropGames()->getName();
                $out[$challenge]['description'] = $val->getDescription();
                $out[$challenge]['author_name'] = $this->challenge_model->get_teacher_name($val->getUserId());
                $out[$challenge]['number_of_questions'] = $this->challenge_builder_model->get_number_of_questions_in_challenge($val->getChallengeId());
                $out[$challenge]['teacher_biography'] = $this->teacher_model->get_teacher_biography_by_user_id($val->getUserId());
                $out[$challenge]['played_times'] = $this->challenge_model->get_challenge_played_times($val->getChallengeId());
        }
        return $out;
    }

    private function get_subject(){
        $subjects = $this->marketplace_model->get_subject();
        $out = array();

        foreach($subjects as $subject=>$val){
            $out[$subject]['subject_id'] = $val->getSubjectId();
            $out[$subject]['subject_name'] = $val->getName();
        }
        return $out;
    }

    private function get_skill(){
        $skills = $this->marketplace_model->get_skill();

        $out = array();

        foreach($skills as $skill=>$val){
            $out[$skill]['skill_id'] = $val->getSkillId();
            $out[$skill]['skill_name'] = $val->getName();
        }
        return $out;
    }

    /**
     * Function for installing new challenge into class
     * @method: POST
     * @params: class_id and challenge_id
     */
    public function install(){

        if($this->form_validation->run('marketplace_install') === false){
            redirect();
        }

        $data = new stdClass();

        $data->class_id = $this->input->post('class_id');
        $data->challenge_id = $this->input->post('challenge_id');

        $new_chal_clas = $this->marketplace_model->save($data);

        redirect('marketplace');
    }

    public function ajax_install(){

        if($this->form_validation->run('marketplace_install') === false){
            redirect();
        }

        $data = new stdClass();

        $data->class_id = $this->input->post('class_id');
        $data->challenge_id = $this->input->post('challenge_id');

        $new_chal_clas = $this->marketplace_model->save($data);

    }

    /**
     * Function for getting classes by teacher id
     * @method: GET
     * @out: list of teachers classes
     */

    public function ajax_get_class(){

        $challenge_id =  $this->input->post('challenge_id');
        $out = array();

        $classes = $this->marketplace_model->get_classes($challenge_id);

        foreach($classes as $class=>$val){
            $installed_on_class = $this->marketplace_model->installed_on_class($val->getClassId(), $challenge_id);
            if($installed_on_class === false){
                $out[$class]['class_id'] = $val->getClassId();
                $out[$class]['class_name'] = $val->getName();
            }
        }

        if(count($out) === 0){
            $out['installed'] = 'all';
        }

        $this->output->set_output(json_encode($out));

    }

    public function ajax_get_skill_by_subject_id($subject, $level){
        $this->load->model('x_subject/skill_model');

        if($level !== 'all'){
            $this->marketplace_model->filterByLevel($level);
        }

        $this->marketplace_model->filterBySubjectId($subject);
        $this->marketplace_model->set_group_by(PropChallengePeer::SKILL_ID);
        $skills = $this->marketplace_model->getList();

        if(empty($skills) === false){
            $out = array();
            foreach($skills as $k=>$v){
                $out[$k]['skill_id'] = $v->getPropSkills()->getSkillId();
                $out[$k]['skill_name'] = $v->getPropSkills()->getName();
            }
            $this->output->set_output(json_encode($out));
        }

    }

    public function ajax_get_skills(){

        $this->load->model('x_subject/skill_model');

        $skills = $this->skill_model->getList();

        if(empty($skills) === false){
            $out = array();
            foreach($skills as $k=>$v){
                $out[$k]['skill_id'] = $v->getSkillId();
                $out[$k]['skill_name'] = $v->getName();
            }

            $this->output->set_output(json_encode($out));
        }

    }

    /**
     * Function for validation form for installing new challenge
     * @method: POST
     * @params: class_id and challenge_id
     * @out: validation errors or true if evrything is ok
     */

    public function ajax_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('marketplace_install') === false){
            if(form_error('class_id') != '')
                $error['class_id'] = "Select class";
            $this->output->set_status_header('400');
        }else{
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }
        $this->output->set_output(json_encode($error));
    }
}