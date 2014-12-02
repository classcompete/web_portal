<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/19/13
 * Time: 3:07 PM
 * To change this template use File | Settings | File Templates.
 */
class Question extends MY_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('x_challenge_question/challenge_questionlib');
        $this->load->library('x_challenge/challengelib');
        $this->load->library('x_question/questionlib');
        $this->load->library('propellib');
        $this->load->library('x_plupload/pluploadlib_new');
        $this->load->library('x_image_crop/image_crop_lib');
        $this->load->library('form_validation');

        $this->propellib->load_object('ChallengeQuestion');
        $this->mapperlib->set_model($this->challenge_question_model);

        $this->mapperlib->add_column('subject_name', 'Subject name', true, 'text', 'PropSubjects');
        $this->mapperlib->add_column('skill_name', 'Skill name', true, 'text', 'PropSkills');
        $this->mapperlib->add_column('level', 'Level', true, 'text', 'PropQuestion');
        $this->mapperlib->add_column('type', 'Type', false , 'text', 'PropQuestion');
        $this->mapperlib->add_column('text', 'Text', false , 'text', 'PropQuestion');
        $this->mapperlib->add_column('correct_choice_id', 'Correct choice id', false);
        $this->mapperlib->add_column('correct_text', 'Correct text', false);

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'username',
            ),
            'uri' => '#question/edit',
            'params' => array(
                'id',
            ),
            'data-toggle' => 'modal',
            'data-target' => '#addEditQuestion'
        ));

        $this->mapperlib->add_order_by('subject_name', 'Subject name');
        $this->mapperlib->add_order_by('skill_name', 'Skill name');
        $this->mapperlib->add_order_by('level', 'Level');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_order(PropChallengeQuestionPeer::QUESTION_ID, Criteria::ASC);
    }

    public function challenge($challenge_id = null){

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('question/challenge/'.$challenge_id.'/' . $uri);
        }

        $this->mapperlib->set_default_base_page('question/challenge/'.$challenge_id);
        $this->mapperlib->set_breaking_segment(4);

        $data = new stdClass();
        $this->challenge_question_model->setChallenge_id($challenge_id);

        $data->challange_id = $challenge_id;

        $challengeQuestions = $this->challenge_question_model->getList();
        $questionIds = array();
        foreach ($challengeQuestions as $cq) {
            /** @var $cq PropChallengeQuestion */
            $questionIds[] = $cq->getQuestionId();
        }

        /**
         * Nem's hack - this should be moved to question_model once
         */
        $questions = PropQuestionQuery::create()
            ->filterByQuestionId($questionIds)
            ->filterByIsDeleted(PropQuestionPeer::IS_DELETED_NO)
            ->find();

        $data->questions = array();

        foreach($questions as $k => $question){
                $data->questions[$k]['question_name'] = $question->getText();
                $question_id = $question->getQuestionId();
                $data->questions[$k]['question_id'] = $question_id;
                $data->questions[$k]['question_type'] = $this->challenge_questionlib->get_question_type($question_id);
                $data->questions[$k]['question_image'] = $this->challenge_questionlib->get_question_image_type($question_id);

                $question_data = $this->get_question_details($question_id);
                $data->questions[$k]['data'] = $question_data;
        }

        $data->content = $this->prepareView('x_challenge_question', 'home_challenge_question', $data);
        $this->load->view(config_item('teacher_template'), $data);
    }

    public function save_question_type_1(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $add_question = $this->input->post('add_new_question');

        if($this->form_validation->run('question_type_1') === false || empty($challenge_id) === true){
            redirect();
        }
        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_1_question');
        $question->type = 'multiple_choice';
        foreach ($this->input->post('question_type_1_answer') as $k => $v) {
            $question->two_answer[$k]['answer'] = $v;
            if ($k === intval($this->input->post('question_type_1_correct'))) {
                $question->two_answer[$k]['correct'] = 'true';
            }
        }

        $ch = $this->challenge_question_model->save_question_1_type($question, $challenge_id, $question_id);

        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_1_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');

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
        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_2(){

        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $add_question = $this->input->post('add_new_question');

        if($this->form_validation->run('question_type_2') === false || empty($challenge_id) === true){
            redirect();
        }
        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_2_question');
        $question->type = 'multiple_choice';
        foreach ($this->input->post('question_type_2_answer') as $k => $v) {
            $question->four_answer[$k]['answer'] = $v;
            if ($k === intval($this->input->post('question_type_2_correct'))) {
                $question->four_answer[$k]['correct'] = 'true';
            }
        }

        $ch = $this->challenge_question_model->save_question_2_type($question, $challenge_id, $question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_2_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');

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
        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_3(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_3_image');
        $add_question = $this->input->post('add_new_question');

        if (isset($question_id) === true && empty($question_id) === false){
            if ($this->form_validation->run('question_type_3_edit') === false) {
                redirect();
            }
        } else {
            if ($this->form_validation->run('question_type_3') === false) {
                redirect();
            }
        }

        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_3_question');

        foreach ($this->input->post('question_type_3_answer') as $k => $v) {
            $question->four_answer[$k]['answer'] = $v;
            if ($k === intval($this->input->post('question_type_3_correct'))) {
                $question->four_answer[$k]['correct'] = 'true';
            }
        }

        $fp = fopen($question_image_link,'r');
        $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
        fclose($fp);

        $question->correct_answer = intval($this->input->post('question_type_3_correct'));
        $question->type = 'multiple_choice';
        $ch = $this->challenge_question_model->save_question_3_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_3_validation(){
        $error = array();

        $this->form_validation->set_error_delimiters('','');
        $question_id = $this->input->post('question_id');

        if (isset($question_id) === true && empty($question_id) === false){
            if($this->form_validation->run('question_type_3_edit') === false){
                for ($i = 1; $i <= 4; $i++) {
                    if(form_error('question_type_3_answer['.$i.']') != '')
                        $error['question_type_3_answer'][$i] = form_error('question_type_3_answer['.$i.']');

                }
                if(form_error('question_type_3_correct') != '')
                    $error['question_type_3_correct'] = 'Select correct answer';
                if(form_error('question_type_3_question') != '')
                    $error['question_type_3_question'] = form_error('question_type_3_question');

                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        } else {
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
                    $error['question_type_3_image'] = 'Image is missing';

                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_4(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $add_question = $this->input->post('add_new_question');

        if (isset($question_id) === true && empty($question_id) === false){
            if ($this->form_validation->run('question_type_4_edit') === false) {
                redirect();
            }
        }else {
            if ($this->form_validation->run('question_type_4') === false) {
                redirect();
            }
        }

        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_4_question');

        foreach ($this->input->post('question_type_4_image') as $k => $v) {
            if (empty($v) === false){
                $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                $fp = fopen($img_link,'r');

                $question->four_image[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                fclose($fp);
            } else {
                $question->four_image[$k]['answer'] = null;
            }

            if ($k === intval($this->input->post('question_type_4_correct'))) {
                $question->four_image[$k]['correct'] = 'true';
            }
        }

        $question->correct_answer = intval($this->input->post('question_type_4_correct'));
        $question->type = 'multiple_choice';
        $ch = $this->challenge_question_model->save_question_4_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_4_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');
        $question_id = $this->input->post('question_id');

        if (isset($question_id) === true && empty($question_id) === false){
            if($this->form_validation->run('question_type_4_edit') === false){
                if(form_error('question_type_4_question') != '')
                    $error['question_type_4_question'] = form_error('question_type_4_question');
                if(form_error('question_type_4_correct') != '')
                    $error['question_type_4_correct'] = 'Select correct answer';
                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }else {
            if($this->form_validation->run('question_type_4') === false){
                if(form_error('question_type_4_question') != '')
                    $error['question_type_4_question'] = form_error('question_type_4_question');
                if(form_error('question_type_4_correct') != '')
                    $error['question_type_4_correct'] = 'Select correct answer';
                if(form_error('question_type_4_image[1]') != '')
                    $error['question_type_4_image'][1] = form_error('question_type_4_image[1]');
                if(form_error('question_type_4_image[2]') != '')
                    $error['question_type_4_image'][2] = form_error('question_type_4_image[2]');
                if(form_error('question_type_4_image[3]') != '')
                    $error['question_type_4_image'][3] = form_error('question_type_4_image[3]');
                if(form_error('question_type_4_image[4]') != '')
                    $error['question_type_4_image'][4] = form_error('question_type_4_image[4]');
                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_5(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $question_image = $this->input->post('question_type_5_question_image');
        $add_question = $this->input->post('add_new_question');

        $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->input->post('question_type_5_question_image');

        if (isset($question_id) === true && empty($question_id) === false){
            if ($this->form_validation->run('question_type_5_edit') === false) {
                redirect();
            }
        }else {
            if ($this->form_validation->run('question_type_5') === false) {
                redirect();
            }
        }

        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_5_question');

        foreach ($this->input->post('question_type_5_answer_image') as $k => $v) {
            $answer_image = $this->input->post('question_type_5_answer_image');

            if(isset($answer_image) === true && empty($answer_image) === false){
                $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR. $v;
                $fp = fopen($img_link,'r');

                $question->four_image[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                fclose($fp);
            }
            if ($k === intval($this->input->post('question_type_5_correct'))) {
                $question->four_image[$k]['correct'] = 'true';
            }
        }

        if(isset($question_image) === true && empty($question_image) === false){
            $fp = fopen($question_image_link,'r');
            $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
            fclose($fp);
        }
        $question->correct_answer = intval($this->input->post('question_type_5_correct'));
        $question->type = 'multiple_choice';
        $ch = $this->challenge_question_model->save_question_5_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_5_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');

        $question_id = $this->input->post('question_id');

        if (isset($question_id) === true && empty($question_id) === false){
            if($this->form_validation->run('question_type_5_edit') === false){
                if(form_error('question_type_5_question') != '')
                    $error['question_type_5_question'] = form_error('question_type_5_question');

                if(form_error('question_type_5_correct') != '')
                    $error['question_type_5_correct'] = 'Select correct answer';

                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        } else {
            if($this->form_validation->run('question_type_5') === false){
                if(form_error('question_type_5_question') != '')
                    $error['question_type_5_question'] = form_error('question_type_5_question');
                if(form_error('question_type_5_question_image') != '')
                    $error['question_type_5_question_image'] = form_error('question_type_5_question_image');
                if(form_error('question_type_5_correct') != '')
                    $error['question_type_5_correct'] = 'Select correct answer';


                if(form_error('question_type_5_answer_image[1]') != '')
                    $error['question_type_5_answer_image'][1] = form_error('question_type_5_answer_image[1]');
                if(form_error('question_type_5_answer_image[2]') != '')
                    $error['question_type_5_answer_image'][2] = form_error('question_type_5_answer_image[2]');
                if(form_error('question_type_5_answer_image[3]') != '')
                    $error['question_type_5_answer_image'][3] = form_error('question_type_5_answer_image[3]');
                if(form_error('question_type_5_answer_image[4]') != '')
                    $error['question_type_5_answer_image'][4] = form_error('question_type_5_answer_image[4]');
                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_6(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $add_question = $this->input->post('add_new_question');

        if ($this->form_validation->run('question_type_6') === false) {
            redirect();
        }
        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_6_question');
        $question->type = 'multiple_choice';

        foreach ($this->input->post('question_type_6_answer') as $k => $v) {
            $question->eight_answer[$k]['answer'] = $v;
            if ($k === intval($this->input->post('question_type_6_correct'))) {
                $question->eight_answer[$k]['correct'] = 'true';
            }
        }

        $question->correct_answer = intval($this->input->post('question_type_6_correct'));
        $ch = $this->challenge_question_model->save_question_6_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_6_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');

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
        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_7(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $add_question = $this->input->post('add_new_question');

        if ($this->form_validation->run('question_type_7') === false) {
            redirect();
        }
        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_7_question');
        $question->type = 'calculator';
        $question->correct_text = $this->input->post('question_type_7_answer');
        $ch = $this->challenge_question_model->save_question_7_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_7_validation(){
        $error = array();

        $this->form_validation->set_error_delimiters('','');

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

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_8(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_8_question_image');
        $add_question = $this->input->post('add_new_question');

        if (isset($question_id) === true && empty($question_id) === false){
            if ($this->form_validation->run('question_type_8_edit') === false) {
                redirect();
            }
        } else {
            if ($this->form_validation->run('question_type_8') === false) {
                redirect();
            }
        }

        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_8_question');
        $question->type = 'calculator';
        $question->correct_text = $this->input->post('question_type_8_answer');

        $fp = fopen($question_image_link,'r');
        $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
        fclose($fp);

        $ch = $this->challenge_question_model->save_question_8_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_8_validation(){
        $error = array();

        $this->form_validation->set_error_delimiters('','');

        $question_id = $this->input->post('question_id');

        if (isset($question_id) === true && empty($question_id) === false){
            if($this->form_validation->run('question_type_8_edit') === false){
                if(form_error('question_type_8_question') != '')
                    $error['question_type_8_question'] = form_error('question_type_8_question');
                if(form_error('question_type_8_question_image') != '')
                    $error['question_type_8_question_image'] = form_error('question_type_8_question_image');
                if(form_error('question_type_8_answer') != '')
                    $error['question_type_8_answer'] = form_error('question_type_8_answer');


                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        } else {
            if($this->form_validation->run('question_type_8') === false){
                if(form_error('question_type_8_question') != '')
                    $error['question_type_8_question'] = form_error('question_type_8_question');
                if(form_error('question_type_8_question_image') != '')
                    $error['question_type_8_question_image'] = form_error('question_type_8_question_image');
                if(form_error('question_type_8_answer') != '')
                    $error['question_type_8_answer'] = form_error('question_type_8_answer');


                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_9(){
        $challenge_id           = $this->input->post('challenge_id');
        $question_id            = $this->input->post('question_id');
        $question_image_link    = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->input->post('question_type_9_question_image');
        $add_question = $this->input->post('add_new_question');

        if (isset($question_id) === true && empty($question_id) === false){
            if ($this->form_validation->run('question_type_9_edit') === false) {
                redirect();
            }
        } else {
            if ($this->form_validation->run('question_type_9') === false) {
                redirect();
            }
        }

        $challenge_data         = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question               = new stdClass();
        $question->subject_id   = $challenge_data->getSubjectId();
        $question->skill_id     = $challenge_data->getSkillId();
        $question->level        = $challenge_data->getLevel();
        $question->topic_id     = $challenge_data->getTopicId();
        $question->text         = $this->input->post('question_type_9_question');
        $question->type         = 'order_slider';

        $fp                     = fopen($question_image_link,'r');
        $question->image_thumb  = base64_encode(fread($fp,filesize($question_image_link)));
        fclose($fp);

        $question->correct_text = $this->input->post('question_type_9_correct_text');

        foreach($this->input->post('question_type_9_answer') as $k=>$v){
            $question->answer[$k]['answer'] = $v;
        }


        $ch = $this->challenge_question_model->save_question_9_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_9_validation(){
        $error = array();

        $this->form_validation->set_error_delimiters('','');

        $question_id = $this->input->post('question_id');

        if (isset($question_id) === true && empty($question_id) === false){
            if($this->form_validation->run('question_type_9_edit') === false){
                if(form_error('question_type_9_question') != '')
                    $error['question_type_9_question'] = form_error('question_type_9_question');

                if(form_error('question_type_9_correct_text') != '')
                    $error['question_type_9_correct_text'] = form_error('question_type_9_correct_text');
                if(form_error('question_type_9_answer[1]') != '')
                    $error['question_type_9_answer'][1] = form_error('question_type_9_answer[1]');
                if(form_error('question_type_9_answer[2]') != '')
                    $error['question_type_9_answer'][2] = form_error('question_type_9_answer[2]');
                if(form_error('question_type_9_answer[3]') != '')
                    $error['question_type_9_answer'][3] = form_error('question_type_9_answer[3]');
                if(form_error('question_type_9_answer[4]') != '')
                    $error['question_type_9_answer'][4] = form_error('question_type_9_answer[4]');


                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        } else {
            if($this->form_validation->run('question_type_9') === false){
                if(form_error('question_type_9_question') != '')
                    $error['question_type_9_question'] = form_error('question_type_9_question');
                if(form_error('question_type_9_question_image') != '')
                    $error['question_type_9_question_image'] = form_error('question_type_9_question_image');
                if(form_error('question_type_9_correct_text') != '')
                    $error['question_type_9_correct_text'] = 'Select correct order';
                if(form_error('question_type_9_answer[1]') != '')
                    $error['question_type_9_answer'][1] = form_error('question_type_9_answer[1]');
                if(form_error('question_type_9_answer[2]') != '')
                    $error['question_type_9_answer'][2] = form_error('question_type_9_answer[2]');
                if(form_error('question_type_9_answer[3]') != '')
                    $error['question_type_9_answer'][3] = form_error('question_type_9_answer[3]');
                if(form_error('question_type_9_answer[4]') != '')
                    $error['question_type_9_answer'][4] = form_error('question_type_9_answer[4]');


                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_10(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $question_image_link = X_TEACHER_UPLOAD_PATH . '/'. $this->input->post('question_type_10_image');
        $add_question = $this->input->post('add_new_question');

        if (isset($question_id) === true && empty($question_id) === false){
            if ($this->form_validation->run('question_type_10_edit') === false) {
                redirect();
            }
        } else {
            if ($this->form_validation->run('question_type_10') === false) {
                redirect();
            }
        }

        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_10_question');

        foreach ($this->input->post('question_type_10_answer') as $k => $v) {
            $question->two_answer[$k]['answer'] = $v;
            if ($k === intval($this->input->post('question_type_10_correct'))) {
                $question->two_answer[$k]['correct'] = 'true';
            }
        }

        $fp = fopen($question_image_link,'r');
        $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
        fclose($fp);

        $question->correct_answer = intval($this->input->post('question_type_10_correct'));
        $question->type = 'multiple_choice';
        $ch = $this->challenge_question_model->save_question_10_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_10_validation(){
        $error = array();

        $this->form_validation->set_error_delimiters('','');
        $question_id = $this->input->post('question_id');

        if (isset($question_id) === true && empty($question_id) === false){
            if($this->form_validation->run('question_type_10_edit') === false){
                for ($i = 1; $i <= 4; $i++) {
                    if(form_error('question_type_10_answer['.$i.']') != '')
                        $error['question_type_10_answer'][$i] = form_error('question_type_10_answer['.$i.']');

                }
                if(form_error('question_type_10_correct') != '')
                    $error['question_type_10_correct'] = 'Select correct answer';
                if(form_error('question_type_10_question') != '')
                    $error['question_type_10_question'] = form_error('question_type_10_question');

                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        } else {
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
                    $error['question_type_10_image'] = 'Image is missing';

                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_11(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $question_image = $this->input->post('question_type_11_question_image');
        $add_question = $this->input->post('add_new_question');

        $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->input->post('question_type_11_question_image');

        if (isset($question_id) === true && empty($question_id) === false){
            if ($this->form_validation->run('question_type_11_edit') === false) {
                redirect();
            }
        }else {
            if ($this->form_validation->run('question_type_11') === false) {
                redirect();
            }
        }

        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_11_question');

        foreach ($this->input->post('question_type_11_answer_image') as $k => $v) {
            $answer_image = $this->input->post('question_type_11_answer_image');

            if(isset($answer_image) === true && empty($answer_image) === false){
                $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR. $v;
                $fp = fopen($img_link,'r');

                $question->two_image[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                fclose($fp);
            }
            if ($k === intval($this->input->post('question_type_11_correct'))) {
                $question->two_image[$k]['correct'] = 'true';
            }
        }

        if(isset($question_image) === true && empty($question_image) === false){
            $fp = fopen($question_image_link,'r');
            $question->image_thumb = base64_encode(fread($fp,filesize($question_image_link)));
            fclose($fp);
        }
        $question->correct_answer = intval($this->input->post('question_type_11_correct'));
        $question->type = 'multiple_choice';
        $ch = $this->challenge_question_model->save_question_11_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_11_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');

        $question_id = $this->input->post('question_id');

        if (isset($question_id) === true && empty($question_id) === false){
            if($this->form_validation->run('question_type_11_edit') === false){
                if(form_error('question_type_11_question') != '')
                    $error['question_type_11_question'] = form_error('question_type_11_question');

                if(form_error('question_type_11_correct') != '')
                    $error['question_type_11_correct'] = 'Select correct answer';

                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        } else {
            if($this->form_validation->run('question_type_11') === false){
                if(form_error('question_type_11_question') != '')
                    $error['question_type_11_question'] = form_error('question_type_11_question');
                if(form_error('question_type_11_question_image') != '')
                    $error['question_type_11_question_image'] = form_error('question_type_11_question_image');
                if(form_error('question_type_11_correct') != '')
                    $error['question_type_11_correct'] = 'Select correct answer';


                if(form_error('question_type_11_answer_image[1]') != '')
                    $error['question_type_11_answer_image'][1] = form_error('question_type_11_answer_image[1]');
                if(form_error('question_type_11_answer_image[2]') != '')
                    $error['question_type_11_answer_image'][2] = form_error('question_type_11_answer_image[2]');
                if(form_error('question_type_11_answer_image[3]') != '')
                    $error['question_type_11_answer_image'][3] = form_error('question_type_11_answer_image[3]');
                if(form_error('question_type_11_answer_image[4]') != '')
                    $error['question_type_11_answer_image'][4] = form_error('question_type_11_answer_image[4]');
                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_12(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $add_question = $this->input->post('add_new_question');

        if (isset($question_id) === true && empty($question_id) === false){
            if ($this->form_validation->run('question_type_12_edit') === false) {
                redirect();
            }
        }else {
            if ($this->form_validation->run('question_type_12') === false) {
                redirect();
            }
        }

        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_12_question');

        foreach ($this->input->post('question_type_12_image') as $k => $v) {
            if (empty($v) === false){
                $img_link = X_TEACHER_UPLOAD_PATH . '/'. $v;
                $fp = fopen($img_link,'r');

                $question->two_image[$k]['answer'] = base64_encode(fread($fp,filesize($img_link)));;
                fclose($fp);
            } else {
                $question->two_image[$k]['answer'] = null;
            }

            if ($k === intval($this->input->post('question_type_12_correct'))) {
                $question->two_image[$k]['correct'] = 'true';
            }
        }

        $question->correct_answer = intval($this->input->post('question_type_12_correct'));
        $question->type = 'multiple_choice';
        $ch = $this->challenge_question_model->save_question_12_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_12_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');
        $question_id = $this->input->post('question_id');

        if (isset($question_id) === true && empty($question_id) === false){
            if($this->form_validation->run('question_type_12_edit') === false){
                if(form_error('question_type_12_question') != '')
                    $error['question_type_12_question'] = form_error('question_type_12_question');
                if(form_error('question_type_12_correct') != '')
                    $error['question_type_12_correct'] = 'Select correct answer';
                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }else {
            if($this->form_validation->run('question_type_12') === false){
                if(form_error('question_type_12_question') != '')
                    $error['question_type_12_question'] = form_error('question_type_12_question');
                if(form_error('question_type_12_correct') != '')
                    $error['question_type_12_correct'] = 'Select correct answer';
                if(form_error('question_type_12_image[1]') != '')
                    $error['question_type_12_image'][1] = form_error('question_type_12_image[1]');
                if(form_error('question_type_12_image[2]') != '')
                    $error['question_type_12_image'][2] = form_error('question_type_12_image[2]');
                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_13(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $add_question = $this->input->post('add_new_question');

        if($this->form_validation->run('question_type_13') === false || empty($challenge_id) === true){
            redirect();
        }
        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_13_question');
        $question->type = 'multiple_choice';
        $question->large_space = 1;
        foreach ($this->input->post('question_type_13_answer') as $k => $v) {
            $question->two_answer[$k]['answer'] = $v;
            if ($k === intval($this->input->post('question_type_13_correct'))) {
                $question->two_answer[$k]['correct'] = 'true';
            }
        }

        $ch = $this->challenge_question_model->save_question_13_type($question, $challenge_id, $question_id);

        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_13_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('question_type_13') === false){
            if(form_error('question_type_13_question') != '')
                $error['question_type_13_question'] = form_error('question_type_13_question');
            if(form_error('question_type_13_correct') != '')
                $error['question_type_13_correct'] = 'Select correct answer';
            if(form_error('question_type_13_answer[1]') != '')
                $error['question_type_13_answer'][1] = form_error('question_type_13_answer[1]');
            if(form_error('question_type_13_answer[2]') != '')
                $error['question_type_13_answer'][2] = form_error('question_type_13_answer[2]');
            $this->output->set_status_header('400');
        }
        else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }
        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_14(){

        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $add_question = $this->input->post('add_new_question');

        if($this->form_validation->run('question_type_14') === false || empty($challenge_id) === true){
            redirect();
        }
        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_14_question');
        $question->type = 'multiple_choice';
        $question->large_space = 1;
        foreach ($this->input->post('question_type_14_answer') as $k => $v) {
            $question->four_answer[$k]['answer'] = $v;
            if ($k === intval($this->input->post('question_type_14_correct'))) {
                $question->four_answer[$k]['correct'] = 'true';
            }
        }

        $ch = $this->challenge_question_model->save_question_14_type($question, $challenge_id, $question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_14_validation(){
        $error = array();
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('question_type_14') === false){
            if(form_error('question_type_14_question') != '')
                $error['question_type_14_question'] = form_error('question_type_14_question');
            if(form_error('question_type_14_correct') != '')
                $error['question_type_14_correct'] = 'Select correct answer';
            if(form_error('question_type_14_answer[1]') != '')
                $error['question_type_14_answer'][1] = form_error('question_type_14_answer[1]');
            if(form_error('question_type_14_answer[2]') != '')
                $error['question_type_14_answer'][2] = form_error('question_type_14_answer[2]');
            if(form_error('question_type_14_answer[3]') != '')
                $error['question_type_14_answer'][3] = form_error('question_type_14_answer[3]');
            if(form_error('question_type_14_answer[4]') != '')
                $error['question_type_14_answer'][4] = form_error('question_type_14_answer[4]');
            $this->output->set_status_header('400');
        }
        else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }
        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_15(){
        $challenge_id           = $this->input->post('challenge_id');
        $question_id            = $this->input->post('question_id');
        $question_image_link    = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->input->post('question_type_15_question_image');
        $add_question = $this->input->post('add_new_question');

        if (isset($question_id) === true && empty($question_id) === false){
            if ($this->form_validation->run('question_type_15_edit') === false) {
                redirect();
            }
        } else {
            if ($this->form_validation->run('question_type_15') === false) {
                redirect();
            }
        }

        $challenge_data         = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question               = new stdClass();
        $question->subject_id   = $challenge_data->getSubjectId();
        $question->skill_id     = $challenge_data->getSkillId();
        $question->level        = $challenge_data->getLevel();
        $question->topic_id     = $challenge_data->getTopicId();
        $question->text         = $this->input->post('question_type_15_question');
        $question->type         = 'order_slider';

        $fp                     = fopen($question_image_link,'r');
        $question->image_thumb  = base64_encode(fread($fp,filesize($question_image_link)));
        fclose($fp);

        $question->correct_text = $this->input->post('question_type_15_correct_text');

        foreach($this->input->post('question_type_15_answer') as $k=>$v){
            $question->answer[$k]['answer'] = $v;
        }


        $ch = $this->challenge_question_model->save_question_15_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_15_validation(){
        $error = array();

        $this->form_validation->set_error_delimiters('','');

        $question_id = $this->input->post('question_id');

        if (isset($question_id) === true && empty($question_id) === false){
            if($this->form_validation->run('question_type_15_edit') === false){
                if(form_error('question_type_15_question') != '')
                    $error['question_type_15_question'] = form_error('question_type_15_question');

                if(form_error('question_type_15_correct_text') != '')
                    $error['question_type_15_correct_text'] = form_error('question_type_15_correct_text');
                if(form_error('question_type_15_answer[1]') != '')
                    $error['question_type_15_answer'][1] = form_error('question_type_15_answer[1]');
                if(form_error('question_type_15_answer[2]') != '')
                    $error['question_type_15_answer'][2] = form_error('question_type_15_answer[2]');
                if(form_error('question_type_15_answer[3]') != '')
                    $error['question_type_15_answer'][3] = form_error('question_type_15_answer[3]');
                if(form_error('question_type_15_answer[4]') != '')
                    $error['question_type_15_answer'][4] = form_error('question_type_15_answer[4]');


                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        } else {
            if($this->form_validation->run('question_type_15') === false){
                if(form_error('question_type_15_question') != '')
                    $error['question_type_15_question'] = form_error('question_type_15_question');
                if(form_error('question_type_15_correct_text') != '')
                    $error['question_type_15_correct_text'] = 'Select correct order';
                if(form_error('question_type_15_answer[1]') != '')
                    $error['question_type_15_answer'][1] = form_error('question_type_15_answer[1]');
                if(form_error('question_type_15_answer[2]') != '')
                    $error['question_type_15_answer'][2] = form_error('question_type_15_answer[2]');
                if(form_error('question_type_15_answer[3]') != '')
                    $error['question_type_15_answer'][3] = form_error('question_type_15_answer[3]');
                if(form_error('question_type_15_answer[4]') != '')
                    $error['question_type_15_answer'][4] = form_error('question_type_15_answer[4]');


                $this->output->set_status_header('400');
            }
            else {
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));
    }

    public function save_question_type_16(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');
        $add_question = $this->input->post('add_new_question');

        if ($this->form_validation->run('question_type_16') === false) {
            redirect();
        }
        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

        $question = new stdClass();
        $question->subject_id = $challenge_data->getSubjectId();
        $question->skill_id = $challenge_data->getSkillId();
        $question->level = $challenge_data->getLevel();
        $question->topic_id = $challenge_data->getTopicId();
        $question->text = $this->input->post('question_type_16_question');
        $question->type = 'keyboard';
        $question->correct_text = $this->input->post('question_type_16_answer');
        $question->read_text = $this->input->post('question_type_16_read_text');
        $ch = $this->challenge_question_model->save_question_16_type($question,$challenge_id,$question_id);
        $this->redirect($add_question, $challenge_id);
    }
    public function ajax_question_type_16_validation(){
        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('question_type_16') === false){
            if(form_error('question_type_16_question') != '')
                $error['question_type_16_question'] = form_error('question_type_16_question');
            if(form_error('question_type_16_answer') != '')
                $error['question_type_16_answer'] = form_error('question_type_16_answer');
            if(form_error('question_type_16_read_text') != '')
                $error['question_type_16_read_text'] = form_error('question_type_16_read_text');

            $this->output->set_status_header('400');
        }
        else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));
    }

    public function upload_image(){
        $image = $this->pluploadlib_new->process_upload();

        if($image != null){

            $out = array(
                'url' => config_item('upload_url').'/'.$image,
                'image_name' => $image
            );

            $this->output->set_output(trim($image));
        }
    }

    public function process_image_crop(){
        $image  = $this->input->post('image');

        $config_data    = array(
            'x_axis' =>     intval($this->input->post('x_axis')),
            'y_axis' =>     intval($this->input->post('y_axis')),
            'width'  =>     intval($this->input->post('width')),
            'height' =>     intval($this->input->post('height')),
            'zoom'   =>     intval($this->input->post('zoom')),
            'red'    =>     intval($this->input->post('red')),
            'green'  =>     intval($this->input->post('green')),
            'blue'   =>     intval($this->input->post('blue')),
        );
        $cropped_image  =  $this->image_crop_lib->process_image(trim($image),$config_data);

        $this->output->set_output(json_encode($cropped_image));
    }

    /*
     * function for get question details
     * @params: question_id
     * @output: question details
     * */
    public function ajax_question_details($question_id){
        $question_details = $this->challenge_question_model->get_question_by_id($question_id);

        $question_type = $this->challenge_questionlib->get_question_image_type($question_id);
        $out = array();
        $out['question_text'] = $question_details->getText();
        $out['question_type'] = $question_type;

        switch($question_type){
            case 'question_type_1':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_2':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_3':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_4':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_5':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_6':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_7':
                $out['correct_text'] = $question_details->getCorrectText();
                break;
            case 'question_type_8':
                $out['correct_text'] = $question_details->getCorrectText();
                $out['question_image'] = $question_details->getQuestionId();
                break;
            case 'question_type_9':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                }
                $out['correct_text'] = $question_details->getCorrectText();
                break;
            case 'question_type_10':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_11':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_12':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_13':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_14':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_15':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                }
                $out['correct_text'] = $question_details->getCorrectText();
                break;
            case 'question_type_16':
                $out['correct_text'] = $question_details->getCorrectText();
                $out['read_text'] = $question_details->getReadText();
                break;

        }

        $this->output->set_output(json_encode($out));
    }

    private function get_question_details($question_id){
        $question_details = $this->challenge_question_model->get_question_by_id($question_id);

        $question_type = $this->challenge_questionlib->get_question_image_type($question_id);
        $out = array();
        $out['question_text'] = $question_details->getText();
        $out['question_type'] = $question_type;

        switch($question_type){
            case 'question_type_1':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_2':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_3':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_4':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_5':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_6':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_7':
                $out['correct_text'] = $question_details->getCorrectText();
                break;
            case 'question_type_8':
                $out['correct_text'] = $question_details->getCorrectText();
                $out['question_image'] = $question_details->getQuestionId();
                break;
            case 'question_type_9':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                }
                $out['correct_text'] = $question_details->getCorrectText();
                break;
            case 'question_type_10':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_11':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_12':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_13':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_14':
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                    if($val->getChoiceId() === $question_details->getCorrectChoiceId()){
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_15':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->challenge_question_model->get_choices_by_question_id($question_id);
                foreach($question_choice as $choice=>$val){
                    $out['answers'][$choice]['text'] = $val->getText();
                }
                $out['correct_text'] = $question_details->getCorrectText();
                break;
            case 'question_type_16':
                $out['correct_text'] = $question_details->getCorrectText();
                $out['read_text'] = $question_details->getReadText();
                break;
        }

        return $out;
    }


    /*
     * function to display question image
     * @params: question_id
     * @output: image
     * */
    public function display_question_image($question_id){

        $image = $this->challenge_question_model->get_question_image($question_id);
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image['image']));
    }

    /*
     * function to display choice image
     * @params: choice_id
     * @output: image
     * */
    public function display_choice_image($choice_id){

        $image = $this->challenge_question_model->display_question_choice_image($choice_id);
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image['image']));

    }

    private function redirect($add_new, $challenge_id){


        if($add_new === false){
            redirect('question/challenge/'.$challenge_id);
        }else{
            if(intval($add_new) === 0){
                $out = array('close'=>true);
                //redirect('question/challenge/'.$challenge_id);
            }else{
                $out = array('close'=>false);
            }
            $this->output->set_output(json_encode($out));
        }
    }

    /** function for delete question */
    public function delete_question(){
        $question_id = $this->input->post('question_id');
        $challenge_id = $this->input->post('challenge_id');

        $question = new stdClass();

        if($this->questionlib->isSafeToDelete($question_id) === true){
            $question->question_id = $question_id;

            $this->question_model->delete($question);
            $this->challenge_question_model->delete($challenge_id, $question_id);
            $out['deleted'] = true;
        }else{
            $out['message'] = "Question have associate data, it can't be deleted";
        }
        $this->output->set_output(json_encode($out));

    }
}