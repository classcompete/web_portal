<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/16/13
 * Time: 10:58 AM
 * To change this template use File | Settings | File Templates.
 */
class Challenge_builder extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('x_challenge_builder/challenge_builderlib');
        $this->load->library('x_question/questionlib');
        $this->load->model('x_users/teacher_model');
        $this->load->model('x_challenge/challenge_model');
        $this->load->library('propellib');
        $this->load->library('form_validation');

        $this->propellib->load_object('Challenge');
        $this->mapperlib->set_model($this->challenge_builder_model);

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
        $this->mapperlib->add_option('question',array(
            'title' => array(
                'base' => 'Questions',
                'filed' => 'name'
            ),
            'uri' => 'question/challenge',
            'params' => array(
                'id'
            )
        ));

        $this->mapperlib->add_order_by('name_challenge', 'Challenge name');
        $this->mapperlib->add_order_by('name_subject', 'Subject name');
        $this->mapperlib->add_order_by('name_skill', 'Skill name');
        $this->mapperlib->add_order_by('level', 'level');
        $this->mapperlib->add_order_by('name_game', 'Game name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('challenge_builder/index');

        $this->mapperlib->set_default_order(PropChallengePeer::NAME, Criteria::ASC);
    }

    /*
     * Content part
     * */
    public function index(){
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('challenge_builder/index/' . $uri);
        }

        $data = new stdClass();

        $this->challenge_builder_model->set_userId(TeacherHelper::getUserId());
        $challenges = $this->challenge_builder_model->getList();
        $data->challenges = array();
        foreach($challenges as $challenge=>$val){
            $data->challenges[$challenge]['challenge_name'] = $val->getName();
            $data->challenges[$challenge]['challenge_id'] = $val->getChallengeId();
            $data->challenges[$challenge]['user_id'] = $val->getUserId();
            $data->challenges[$challenge]['author_name'] = $this->challenge_builder_model->get_teacher_name($val->getUserId());
            $data->challenges[$challenge]['description'] = $val->getDescription();
            $data->challenges[$challenge]['teacher_biography'] = $this->teacher_model->get_teacher_biography_by_user_id($val->getUserId());

            if($val->getUserId() === TeacherHelper::getUserId()){
                $data->challenges[$challenge]['edit_challenge'] = $val->getChallengeId();
            }

            // data for tooltip
            $data->challenges[$challenge]['data']['subject_name'] = $val->getPropSubjects()->getName();
            $data->challenges[$challenge]['data']['subject_id'] = $val->getSubjectId();
            $data->challenges[$challenge]['data']['skill_id'] = $val->getSkillId();
            $data->challenges[$challenge]['data']['skill_name'] = $val->getPropSkills()->getName();
            $data->challenges[$challenge]['data']['topic_name'] = $val->getPropTopic()->getName();

            $level = $val->getLevel();
            if($level === -2)$level = 'Pre k';
            else if($level === -1)$level = "K";
            $data->challenges[$challenge]['data']['level'] = $level;
            $data->challenges[$challenge]['data']['game_name'] = $val->getPropGames()->getName();
            $data->challenges[$challenge]['data']['number_of_questions'] = $this->challenge_builder_model->get_number_of_questions_in_challenge($val->getChallengeId());
            $data->challenges[$challenge]['data']['played_times'] = $this->challenge_model->get_challenge_played_times($val->getChallengeId());
        }

        $data->subjects = $this->get_subject();
        $data->skills = $this->get_skill();
        $data->content = $this->prepareView('x_challenge_builder', 'home', $data);

        $this->load->view(config_item('teacher_template'), $data);

    }

	/**
	 * Save basic challenge data through ajax call
	 */
    public function ajax_save_challenge(){
	    $out = array();

	    try {
		    if ($this->form_validation->run('challenge_builder') === false) {
			    $this->output->set_status_header('400');
				$out['error'] = 'Data not valid';
			    $this->output->set_output(json_encode($out));
			    exit;
			}

		        //Pedja: when saving challenge it doesn't need to be assigned to any class
		    /*if($this->form_validation->run('challenge_builder_class') == false){
				redirect();
			}*/
		    $challenge = new stdClass();

		    $challenge->name = $this->input->post('challenge_name');
		    $challenge->subject_id = $this->input->post('subject_id');
		    $challenge->skill_id = $this->input->post('skill_id');
		    $challenge->topic_id = $this->input->post('topic_id');
		    $challenge->level = $this->input->post('level');
		    $challenge->game_id = $this->input->post('game_id');
		    $challenge->description = $this->input->post('description');
		    $challenge->user_id = TeacherHelper::getUserId();
		    $challenge->read_title = $this->input->post('read_title');
		    $challenge->read_text = $this->input->post('read_text');

		    $readImageName = $this->input->post('read_image');
		    if (empty($readImageName) === false) {
			    $imageLink = X_TEACHER_UPLOAD_PATH . '/' . $readImageName;

			    $fp = fopen($imageLink, 'r');
			    $challenge->read_image = base64_encode(fread($fp, filesize($imageLink)));
			    fclose($fp);
		    }

		    $is_public = $this->input->post('public_challenge');

		    if ($is_public === PropChallengePeer::IS_PUBLIC_YES) {
			    $challenge->is_public = PropChallengePeer::IS_PUBLIC_YES;
		    } else {
			    $challenge->is_public = PropChallengePeer::IS_PUBLIC_NO;
		    }

		    if (intval($this->input->post('class_id')) > 0) {
			    $challenge->class_id = $this->input->post('class_id');
		    }
		    $ch = $this->challenge_builder_model->save_challenge($challenge);

		    $add_question = $this->input->post('add_question');
		    if (intval($add_question) === 1) {
			    $out = array(
			        'challenge_id' => $ch->getChallengeId()
			    );
		    } else {
			    $out = array(
			        'save_and_close' => true
			    );
		    }
	    } catch (Exception $e) {
		    $this->output->set_status_header('400');
			$out['error'] = $e->getMessage();
	    }

        $this->output->set_output(json_encode($out));
    }

    public function ajax_save_question(){
        $challenge_id = $this->input->post('challenge_id');
        $question_type = $this->input->post('question_type');
        $add_question = $this->input->post('add_question');

        $question = new stdClass();

        /*
         * Prepare question data for save
         * */
        switch($question_type){
            case 'question_type_1':
                if($this->form_validation->run('question_type_1') === false){
                    redirect();
                }
                $question->text = $this->input->post('question_type_1_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_1_answer') as $k => $v) {
                    $question->question_type_1[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_1_correct'))) {
                        $question->question_type_1[$k]['correct'] = 'true';
                    }
                }
                break;
            case 'question_type_2':
                if($this->form_validation->run('question_type_2') === false){
                    redirect();
                }
                $question->text = $this->input->post('question_type_2_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_2_answer') as $k => $v) {
                    $question->question_type_2[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_2_correct'))) {
                        $question->question_type_2[$k]['correct'] = 'true';
                    }
                }

                break;
            case 'question_type_3':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_3_image');

                if ($this->form_validation->run('question_type_3') === false) {
                    redirect();
                }
                $question->text = $this->input->post('question_type_3_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_3_answer') as $k => $v) {
                    $question->question_type_3[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_3_correct'))) {
                        $question->question_type_3[$k]['correct'] = 'true';
                    }
                }

                $fp = fopen($question_image_link,'r');
                $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);

                break;
            case 'question_type_4':
                if ($this->form_validation->run('question_type_4') === false) {
                    redirect();
                }
                $question->text = $this->input->post('question_type_4_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_4_image') as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                    $fp = fopen($img_link,'r');

                    $question->question_type_4[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                    fclose($fp);
                    if ($k === intval($this->input->post('question_type_4_correct'))) {
                        $question->question_type_4[$k]['correct'] = 'true';
                    }
                }

                break;
            case 'question_type_5':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_5_question_image');

                if ($this->form_validation->run('question_type_5') === false) {
                    redirect();
                }
                $question->text = $this->input->post('question_type_5_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_5_answer_image') as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                    $fp = fopen($img_link,'r');

                    $question->question_type_5[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                    fclose($fp);
                    if ($k === intval($this->input->post('question_type_5_correct'))) {
                        $question->question_type_5[$k]['correct'] = 'true';
                    }
                }
                $fp = fopen($question_image_link,'r');
                $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);
                break;
            case 'question_type_6':
                if ($this->form_validation->run('question_type_6') === false) {
                    redirect();
                }
                $question->text = $this->input->post('question_type_6_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_6_answer') as $k => $v) {
                    $question->question_type_6[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_6_correct'))) {
                        $question->question_type_6[$k]['correct'] = 'true';
                    }
                }

                break;
            case 'question_type_7':
                if ($this->form_validation->run('question_type_7') === false) {
                    redirect();
                }

                $question->text = $this->input->post('question_type_7_question');
                $question->type = 'calculator';
                $question->correct_text = $this->input->post('question_type_7_answer');
                break;
            case 'question_type_8':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_8_question_image');

                if ($this->form_validation->run('question_type_8') === false) {
                    redirect();
                }
                $question->text = $this->input->post('question_type_8_question');
                $question->correct_text = $this->input->post('question_type_8_answer');
                $question->type = 'calculator';
                $fp = fopen($question_image_link,'r');
                $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);
                break;
            case 'question_type_9':
                if ($this->form_validation->run('question_type_9') === false) {
                    redirect();
                }

                $question_image_link     = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->input->post('question_type_9_question_image');
                $question->text         = $this->input->post('question_type_9_question');
                $question->type         = 'order_slider';

                $fp                      = fopen($question_image_link,'r');
                $question->image_thumb  = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);

                $question->correct_text = $this->input->post('question_type_9_correct_text');

                foreach($this->input->post('question_type_9_answer') as $k=>$v){
                    $question->answer[$k]['answer'] = $v;
                }

                break;
            case 'question_type_10':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_10_image');

                if ($this->form_validation->run('question_type_10') === false) {
                    redirect();
                }
                $question->text = $this->input->post('question_type_10_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_10_answer') as $k => $v) {
                    $question->question_type_10[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_10_correct'))) {
                        $question->question_type_10[$k]['correct'] = 'true';
                    }
                }

                $fp = fopen($question_image_link,'r');
                $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);

                break;
            case 'question_type_11':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_11_question_image');

                if ($this->form_validation->run('question_type_11') === false) {
                    redirect();
                }
                $question->text = $this->input->post('question_type_11_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_11_answer_image') as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                    $fp = fopen($img_link,'r');

                    $question->question_type_11[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                    fclose($fp);
                    if ($k === intval($this->input->post('question_type_11_correct'))) {
                        $question->question_type_11[$k]['correct'] = 'true';
                    }
                }
                $fp = fopen($question_image_link,'r');
                $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);
                break;
            case 'question_type_12':
                if ($this->form_validation->run('question_type_12') === false) {
                    redirect();
                }
                $question->text = $this->input->post('question_type_12_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_12_image') as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                    $fp = fopen($img_link,'r');

                    $question->question_type_12[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                    fclose($fp);
                    if ($k === intval($this->input->post('question_type_12_correct'))) {
                        $question->question_type_12[$k]['correct'] = 'true';
                    }
                }

                break;
            case 'question_type_13':
                if($this->form_validation->run('question_type_13') === false){
                    redirect();
                }
                $question->text = $this->input->post('question_type_13_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_13_answer') as $k => $v) {
                    $question->question_type_13[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_13_correct'))) {
                        $question->question_type_13[$k]['correct'] = 'true';
                    }
                }
                break;
            case 'question_type_14':
                if($this->form_validation->run('question_type_14') === false){
                    redirect();
                }
                $question->text = $this->input->post('question_type_14_question');
                $question->type = 'multiple_choice';
                foreach ($this->input->post('question_type_14_answer') as $k => $v) {
                    $question->question_type_14[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_14_correct'))) {
                        $question->question_type_14[$k]['correct'] = 'true';
                    }
                }

                break;
        }


        $question_saved = $this->challenge_builder_model->save_question($question, $challenge_id);

        if(intval($add_question) === 1){
            $out = array(
                'close' => false
            );
        }else{
            $out = array(
                'close' => true
            );
        }

        $this->output->set_output(json_encode($out));
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

        $new_chal_clas = $this->challenge_builder_model->install_challenge_to_class($data);

        redirect('challenge_builder');
    }

    /**
     * Function for validation form for installing new challenge
     * @method: POST
     * @params: class_id and challenge_id
     * @out: validation errors or true if evrything is ok
     */

    public function ajax_install_validation(){
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

    public function save_challenge(){

        $challenge_id = $this->input->post('challenge_id');
        $question_type = $this->input->post('question_type');

        if ($this->form_validation->run('challenge_builder') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $challenge_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $challenge = new stdClass();

        $challenge->name = $this->input->post('challenge_name');
        $challenge->subject_id = $this->input->post('subject_id');
        $challenge->skill_id = $this->input->post('skill_id');
        $challenge->topic_id = $this->input->post('topic_id');
        $challenge->level = $this->input->post('level');
        $challenge->game_id = $this->input->post('game_id');
        $challenge->description = $this->input->post('description');
        $challenge->user_id = TeacherHelper::getUserId();
        $challenge->question_type = $question_type;
        $challenge->read_title = $this->input->post('read_title');
        $challenge->read_text = $this->input->post('read_text');
        $challenge->challenge_id = $challenge_id;

        $is_public = $this->input->post('public_challenge');

        $readImageName = $this->input->post('read_image');

        if (empty($readImageName) === false) {
            $imageLink = X_TEACHER_UPLOAD_PATH . '/'. $readImageName;

            $fp = fopen($imageLink,'r');
            $challenge->read_image = base64_encode(fread($fp,filesize($imageLink)));
            fclose($fp);
        }


        if($is_public === PropChallengePeer::IS_PUBLIC_YES){
            $challenge->is_public = PropChallengePeer::IS_PUBLIC_YES;
        } else {
            $challenge->is_public = PropChallengePeer::IS_PUBLIC_NO;
        }

        /*
         * Prepare question data for save
         * */
        switch($question_type){
            case 'question_type_1':
                if($this->form_validation->run('question_type_1') === false){
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_1_question');
                $challenge->type = 'multiple_choice';
                foreach ($this->input->post('question_type_1_answer') as $k => $v) {
                    $challenge->question_type_1[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_1_correct'))) {
                        $challenge->question_type_1[$k]['correct'] = 'true';
                    }
                }
                break;
            case 'question_type_2':
                if($this->form_validation->run('question_type_2') === false){
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_2_question');
                $challenge->type = 'multiple_choice';
                foreach ($this->input->post('question_type_2_answer') as $k => $v) {
                    $challenge->question_type_2[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_2_correct'))) {
                        $challenge->question_type_2[$k]['correct'] = 'true';
                    }
                }

                break;
            case 'question_type_3':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_3_image');

                if ($this->form_validation->run('question_type_3') === false) {
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_3_question');
                $challenge->type = 'multiple_choice';
                foreach ($this->input->post('question_type_3_answer') as $k => $v) {
                    $challenge->question_type_3[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_3_correct'))) {
                        $challenge->question_type_3[$k]['correct'] = 'true';
                    }
                }

                $fp = fopen($question_image_link,'r');
                $challenge->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);

                break;
            case 'question_type_4':
                if ($this->form_validation->run('question_type_4') === false) {
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_4_question');
                $challenge->type = 'multiple_choice';
                foreach ($this->input->post('question_type_4_image') as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                    $fp = fopen($img_link,'r');

                    $challenge->question_type_4[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                    fclose($fp);
                    if ($k === intval($this->input->post('question_type_4_correct'))) {
                        $challenge->question_type_4[$k]['correct'] = 'true';
                    }
                }

                break;
            case 'question_type_5':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_5_question_image');

                if ($this->form_validation->run('question_type_5') === false) {
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_5_question');
                $challenge->type = 'multiple_choice';
                foreach ($this->input->post('question_type_5_answer_image') as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                    $fp = fopen($img_link,'r');

                    $challenge->question_type_5[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                    fclose($fp);
                    if ($k === intval($this->input->post('question_type_5_correct'))) {
                        $challenge->question_type_5[$k]['correct'] = 'true';
                    }
                }
                $fp = fopen($question_image_link,'r');
                $challenge->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);
                break;
            case 'question_type_6':
                if ($this->form_validation->run('question_type_6') === false) {
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_6_question');
                $challenge->type = 'multiple_choice';
                foreach ($this->input->post('question_type_6_answer') as $k => $v) {
                    $challenge->question_type_6[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_6_correct'))) {
                        $challenge->question_type_6[$k]['correct'] = 'true';
                    }
                }

                break;
            case 'question_type_7':
                if ($this->form_validation->run('question_type_7') === false) {
                    redirect();
                }

                $challenge->text = $this->input->post('question_type_7_question');
                $challenge->type = 'calculator';
                $challenge->correct_text = $this->input->post('question_type_7_answer');
                break;
            case 'question_type_8':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_8_question_image');

                if ($this->form_validation->run('question_type_8') === false) {
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_8_question');
                $challenge->correct_text = $this->input->post('question_type_8_answer');
                $challenge->type = 'calculator';
                $fp = fopen($question_image_link,'r');
                $challenge->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);
                break;
            case 'question_type_9':
                if ($this->form_validation->run('question_type_9') === false) {
                    redirect();
                }

                $question_image_link     = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->input->post('question_type_9_question_image');
                $challenge->text         = $this->input->post('question_type_9_question');
                $challenge->type         = 'order_slider';

                $fp                      = fopen($question_image_link,'r');
                $challenge->image_thumb  = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);

                $challenge->correct_text = $this->input->post('question_type_9_correct_text');

                foreach($this->input->post('question_type_9_answer') as $k=>$v){
                    $challenge->answer[$k]['answer'] = $v;
                }

                break;
            case 'question_type_10':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_10_image');

                if ($this->form_validation->run('question_type_10') === false) {
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_10_question');
                $challenge->type = 'multiple_choice';
                foreach ($this->input->post('question_type_10_answer') as $k => $v) {
                    $challenge->question_type_10[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_10_correct'))) {
                        $challenge->question_type_10[$k]['correct'] = 'true';
                    }
                }

                $fp = fopen($question_image_link,'r');
                $challenge->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);

                break;
            case 'question_type_11':
                $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_11_question_image');

                if ($this->form_validation->run('question_type_11') === false) {
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_11_question');
                $challenge->type = 'multiple_choice';
                foreach ($this->input->post('question_type_11_answer_image') as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                    $fp = fopen($img_link,'r');

                    $challenge->question_type_11[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                    fclose($fp);
                    if ($k === intval($this->input->post('question_type_11_correct'))) {
                        $challenge->question_type_11[$k]['correct'] = 'true';
                    }
                }
                $fp = fopen($question_image_link,'r');
                $challenge->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
                fclose($fp);
                break;
            case 'question_type_12':
                if ($this->form_validation->run('question_type_12') === false) {
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_12_question');
                $challenge->type = 'multiple_choice';
                foreach ($this->input->post('question_type_12_image') as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                    $fp = fopen($img_link,'r');

                    $challenge->question_type_12[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                    fclose($fp);
                    if ($k === intval($this->input->post('question_type_12_correct'))) {
                        $challenge->question_type_12[$k]['correct'] = 'true';
                    }
                }

                break;
            case 'question_type_13':
                if($this->form_validation->run('question_type_13') === false){
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_13_question');
                $challenge->type = 'multiple_choice';
                $challenge->large_space = PropQuestionPeer::LARGE_SPACE_YES;
                foreach ($this->input->post('question_type_13_answer') as $k => $v) {
                    $challenge->question_type_13[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_13_correct'))) {
                        $challenge->question_type_13[$k]['correct'] = 'true';
                    }
                }
                break;
            case 'question_type_14':
                if($this->form_validation->run('question_type_14') === false){
                    redirect();
                }
                $challenge->text = $this->input->post('question_type_14_question');
                $challenge->type = 'multiple_choice';
                $challenge->large_space = PropQuestionPeer::LARGE_SPACE_YES;
                foreach ($this->input->post('question_type_14_answer') as $k => $v) {
                    $challenge->question_type_14[$k]['answer'] = $v;
                    if ($k === intval($this->input->post('question_type_14_correct'))) {
                        $challenge->question_type_14[$k]['correct'] = 'true';
                    }
                }

                break;
            case 'question_type_15':
                if ($this->form_validation->run('question_type_15') === false) {
                    redirect();
                }

                $challenge->text         = $this->input->post('question_type_15_question');
                $challenge->type         = 'order_slider';

                $challenge->correct_text = $this->input->post('question_type_15_correct_text');

                foreach($this->input->post('question_type_15_answer') as $k=>$v){
                    $challenge->answer[$k]['answer'] = $v;
                }

                break;
            case 'question_type_16':
                if ($this->form_validation->run('question_type_16') === false) {
                    redirect();
                }

                $challenge->text = $this->input->post('question_type_16_question');
                $challenge->type = 'keyboard';
                $challenge->correct_text = $this->input->post('question_type_16_answer');
                $challenge->read_text = $this->input->post('question_type_16_read_text');
                break;
        }


        if($this->form_validation->run('challenge_builder_class') == false){
            redirect();
        }
        if (intval($this->input->post('class_id')) > 0){
            $challenge->class_id = $this->input->post('class_id');
        }

        $ch = $this->challenge_builder_model->save($challenge,$challenge_id);

        if ((bool)$this->input->post('new') === true){
            redirect('question/challenge/'.$ch->getChallengeId().'/add_new');
        } else {
            redirect('question/challenge/'.$ch->getChallengeId());
        }

    }
    public function ajax_validation_save_challenge(){
        $error = array();
        $is_error = false;

        $challenge_name = $this->input->post('challenge_name');
        $challenge_id = $this->input->post('id');

        $unique_name = $this->challenge_builder_model->is_challenge_name_unique($challenge_name, $challenge_id);

        $this->form_validation->set_error_delimiters('','');

        if ($unique_name === false) {
            $error['challenge_name'] = 'Challenge Name must be unique. Please enter new one.';
            $is_error = true;
        }
        if($this->form_validation->run('challenge_builder') === false){
            $is_error = true;
            if(form_error('challenge_name') != ''){
                $error['challenge_name'] = form_error('challenge_name');
            }
            if(form_error('subject_id') != '')
                $error['subject_id'] = form_error('subject_id');
            if(form_error('skill_id') != '')
                $error['skill_id'] = form_error('skill_id');
            if(form_error('topic_id') != '')
                $error['topic_id'] = form_error('topic_id');
            if(form_error('level') != '')
                $error['level'] = form_error('level');
            if(form_error('game_id') != '')
                $error['game_id'] = form_error('game_id');
        }

        if ($is_error === false) {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        } else {

            $this->output->set_status_header('400');
        }

        $this->output->set_output(json_encode($error));
    }
    public function ajax_validation_save_question(){
        $question_type = $this->input->post('question_type');
        $this->form_validation->set_error_delimiters('','');
        $error = array();
        switch($question_type){
            case 'question_type_1':
                if($this->form_validation->run('question_type_1') === false){
                    if(form_error('question_type_1_question') != '')
                        $error['question_type_1_question'] = form_error('question_type_1_question');
                    if(form_error('question_type_1_correct') != '')
                        $error['question_type_1_correct'] = 'Select correct answer';
                    if(form_error('question_type_1_answer[1]') != '')
                        $error['question_type_1_answer'][1] = form_error('question_type_1_answer[1]');
                    if(form_error('question_type_1_answer[2]') != '')
                        $error['question_type_1_answer'][2] = form_error('question_type_1_answer[2]');
                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_2':
                if($this->form_validation->run('question_type_2') === false){
                    if(form_error('question_type_2_question') != '')
                        $error['question_type_2_question'] = form_error('question_type_2_question');
                    if(form_error('question_type_2_correct') != '')
                        $error['question_type_2_correct'] = 'Select correct answer';
                    if(form_error('question_type_2_answer[1]') != '')
                        $error['question_type_2_answer'][1] = form_error('question_type_2_answer[1]');
                    if(form_error('question_type_2_answer[2]') != '')
                        $error['question_type_2_answer'][2] = form_error('question_type_2_answer[2]');
                    if(form_error('question_type_2_answer[3]') != '')
                        $error['question_type_2_answer'][3] = form_error('question_type_2_answer[3]');
                    if(form_error('question_type_2_answer[4]') != '')
                        $error['question_type_2_answer'][4] = form_error('question_type_2_answer[4]');
                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_3':
                if($this->form_validation->run('question_type_3') === false){
                    for ($i = 1; $i <= 4; $i++) {
                        if(form_error('question_type_3_answer['.$i.']') != '')
                            $error['question_type_3_answer'][$i] = form_error('question_type_3_answer['.$i.']');

                    }
                    if(form_error('question_type_3_correct') != '')
                        $error['question_type_3_correct'] = 'Select correct answer';
                    if(form_error('question_type_3_question') != '')
                        $error['question_type_3_question'] = form_error('question_type_3_question');
                    if(form_error('question_type_3_image') != '')
                        $error['question_type_3_image'] = 'Image is required';
                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_4':
                if($this->form_validation->run('question_type_4') === false){
                    if(form_error('question_type_4_question') != '')
                        $error['question_type_4_question'] = form_error('question_type_4_question');
                    if(form_error('question_type_4_correct') != '')
                        $error['question_type_4_correct'] = 'Select correct answer';
                    if(form_error('question_type_4_image[1]') != '')
                        $error['question_type_4_image'][1] = 'Image 1 is required';
                    if(form_error('question_type_4_image[2]') != '')
                        $error['question_type_4_image'][2] = 'Image 2 is required';
                    if(form_error('question_type_4_image[3]') != '')
                        $error['question_type_4_image'][3] = 'Image 3 is required';
                    if(form_error('question_type_4_image[4]') != '')
                        $error['question_type_4_image'][4] = 'Image 4 is required';
                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_5':
                if($this->form_validation->run('question_type_5') === false){
                    if(form_error('question_type_5_question') != '')
                        $error['question_type_5_question'] = form_error('question_type_5_question');
                    if(form_error('question_type_5_question_image') != '')
                        $error['question_type_5_question_image'] = 'Question image is required';
                    if(form_error('question_type_5_correct') != '')
                        $error['question_type_5_correct'] = 'Select correct answer';


                    if(form_error('question_type_5_answer_image[1]') != '')
                        $error['question_type_5_answer_image'][1] = 'Answer image 1 is required';
                    if(form_error('question_type_5_answer_image[2]') != '')
                        $error['question_type_5_answer_image'][2] = 'Answer image 2 is required';
                    if(form_error('question_type_5_answer_image[3]') != '')
                        $error['question_type_5_answer_image'][3] = 'Answer image 3 is required';
                    if(form_error('question_type_5_answer_image[4]') != '')
                        $error['question_type_5_answer_image'][4] = 'Answer image 4 is required';
                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_6':
                if($this->form_validation->run('question_type_6') === false){
                    if(form_error('question_type_6_question') != '')
                        $error['question_type_6_question'] = form_error('question_type_6_question');
                    if(form_error('question_type_6_correct') != '')
                        $error['question_type_6_correct'] = 'Select correct answer';
                    if(form_error('question_type_6_answer[1]') != '')
                        $error['question_type_6_answer'][1] = form_error('question_type_6_answer[1]');
                    if(form_error('question_type_6_answer[2]') != '')
                        $error['question_type_6_answer'][2] = form_error('question_type_6_answer[2]');
                    if(form_error('question_type_6_answer[3]') != '')
                        $error['question_type_6_answer'][3] = form_error('question_type_6_answer[3]');
                    if(form_error('question_type_6_answer[4]') != '')
                        $error['question_type_6_answer'][4] = form_error('question_type_6_answer[4]');
                    if(form_error('question_type_6_answer[5]') != '')
                        $error['question_type_6_answer'][5] = form_error('question_type_6_answer[5]');
                    if(form_error('question_type_6_answer[6]') != '')
                        $error['question_type_6_answer'][6] = form_error('question_type_6_answer[6]');
                    if(form_error('question_type_6_answer[7]') != '')
                        $error['question_type_6_answer'][7] = form_error('question_type_6_answer[7]');
                    if(form_error('question_type_6_answer[8]') != '')
                        $error['question_type_6_answer'][8] = form_error('question_type_6_answer[8]');
                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_7':
                if($this->form_validation->run('question_type_7') === false){
                    if(form_error('question_type_7_question') != '')
                        $error['question_type_7_question'] = form_error('question_type_7_question');
                    if(form_error('question_type_7_answer') != '')
                        $error['question_type_7_answer'] = form_error('question_type_7_answer');

                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_8':
                if($this->form_validation->run('question_type_8') === false){
                    if(form_error('question_type_8_question') != '')
                        $error['question_type_8_question'] = form_error('question_type_8_question');
                    if(form_error('question_type_8_question_image') != '')
                        $error['question_type_8_question_image'] = 'Question image is required';
                    if(form_error('question_type_8_answer') != '')
                        $error['question_type_8_answer'] = form_error('question_type_8_answer');


                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_9':
                break;
            case 'question_type_10':
                if($this->form_validation->run('question_type_10') === false){
                    for ($i = 1; $i <= 4; $i++) {
                        if(form_error('question_type_10_answer['.$i.']') != '')
                            $error['question_type_10_answer'][$i] = form_error('question_type_10_answer['.$i.']');

                    }
                    if(form_error('question_type_10_correct') != '')
                        $error['question_type_10_correct'] = 'Select correct answer';
                    if(form_error('question_type_10_question') != '')
                        $error['question_type_10_question'] = form_error('question_type_10_question');
                    if(form_error('question_type_10_image') != '')
                        $error['question_type_10_image'] = 'Image is required';
                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_11':
                if($this->form_validation->run('question_type_11') === false){
                    if(form_error('question_type_11_question') != '')
                        $error['question_type_11_question'] = form_error('question_type_11_question');
                    if(form_error('question_type_11_question_image') != '')
                        $error['question_type_11_question_image'] = 'Question image is required';
                    if(form_error('question_type_11_correct') != '')
                        $error['question_type_11_correct'] = 'Select correct answer';


                    if(form_error('question_type_11_answer_image[1]') != '')
                        $error['question_type_11_answer_image'][1] = 'Answer image 1 is required';
                    if(form_error('question_type_11_answer_image[2]') != '')
                        $error['question_type_11_answer_image'][2] = 'Answer image 2 is required';
                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_12':
                if($this->form_validation->run('question_type_12') === false){
                    if(form_error('question_type_12_question') != '')
                        $error['question_type_12_question'] = form_error('question_type_12_question');
                    if(form_error('question_type_12_correct') != '')
                        $error['question_type_12_correct'] = 'Select correct answer';
                    if(form_error('question_type_12_image[1]') != '')
                        $error['question_type_12_image'][1] = 'Image 1 is required';
                    if(form_error('question_type_12_image[2]') != '')
                        $error['question_type_12_image'][2] = 'Image 2 is required';
                    $this->output->set_status_header('400');
                }
                else {
                    $error['validation'] = true;
                    $this->output->set_status_header('200');
                }
                break;
            case 'question_type_15':
                break;
        }
        $this->output->set_output(json_encode($error));
    }
    public function ajax_validation_save_class(){
        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('challenge_builder_class') === false){
            if(form_error('class_id') != '')
                $error['class_id'] = 'Select class rom';
            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));
    }
    public function ajax($challenge_id){

        $challenge = $this->challenge_model->get_challenge_by_id($challenge_id);

        $this->output->set_output(json_encode($challenge));

    }
    public function ajax_get_subject(){
        $subject = $this->challenge_builder_model->get_subject();

        if(empty($subject) === false){
            $out = array();
            foreach($subject as $k=>$s){
                $out[$k]['subject_id'] = $s->getSubjectId();
                $out[$k]['name'] = $s->getName();
            }
        }

        $this->output->set_output(json_encode($out));
    }

	/**
	 * Get all topics (skills) for specified subject
	 * @param $subject_id
	 */
    public function ajax_get_skill($subject_id){

        $skill = $this->challenge_builder_model->get_skill($subject_id);

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
        $topic = $this->challenge_builder_model->get_topic($skill_id);

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
        $game = $this->challenge_builder_model->get_game();

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

        $game_level = $this->challenge_builder_model->get_game_level($game_id);

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
     * function for getting teacher class
     * */
    public function ajax_get_classes(){
        $classes = $this->challenge_builder_model->get_teacher_classes(TeacherHelper::getId());

        $out = array();

        foreach($classes as $k=>$v){
            $out[$k]['class_id'] = $v->getClassId();
            $out[$k]['class_name'] = $v->getName();
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

    /**
     * Function for getting classes by teacher id
     * @method: GET
     * @out: list of teachers classes
     */

    public function ajax_get_class(){

        $challenge_id =  $this->input->post('challenge_id');
        $out = array();

        $classes = $this->challenge_builder_model->get_classes($challenge_id);

        foreach($classes as $class=>$val){
            $installed_on_class = $this->challenge_builder_model->installed_on_class($val->getClassId(), $challenge_id);
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

    private function get_subject(){
        $this->load->model('x_marketplace/marketplace_model');
        $subjects = $this->marketplace_model->get_subject();
        $out = array();

        foreach($subjects as $subject=>$val){
            $out[$subject]['subject_id'] = $val->getSubjectId();
            $out[$subject]['subject_name'] = $val->getName();
        }
        return $out;
    }

    private function get_skill(){
        $this->load->model('x_marketplace/marketplace_model');
        $skills = $this->marketplace_model->get_skill();

        $out = array();

        foreach($skills as $skill=>$val){
            $out[$skill]['skill_id'] = $val->getSkillId();
            $out[$skill]['skill_name'] = $val->getName();
        }
        return $out;
    }

    public function ajax_is_challenge_name_unique(){
        $name = $this->input->post('name');
        if (empty($name) === true) {
            $out = false;
        } else {
            $out = $this->challenge_builder_model->is_challenge_name_unique($name);
        }

        return $this->output->set_output(json_encode(array('unique_name' => $out)));
    }

}