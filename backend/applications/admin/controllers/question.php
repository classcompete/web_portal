<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/17/13
 * Time: 11:46 AM
 * To change this template use File | Settings | File Templates.
 */
class Question extends MY_Controller
{
    
    public function __construct()
    {
        parent:: __construct();
        
        $this->load->library('x_question/questionlib');
        $this->load->library('x_challenge_question/challenge_questionlib');
        $this->load->library('propellib');
        $this->load->library('form_validation');
        $this->load->library('x_image_crop/image_crop_lib');
        $this->load->model('x_challenge_question/challenge_question_model');
        $this->load->library('x_plupload/pluploadlib_admin');

        $this->propellib->load_object('Question');
        $this->mapperlib->set_model($this->question_model);

        $this->mapperlib->add_column('subject_name', 'Subject', true, 'text', 'PropSubjects');
        $this->mapperlib->add_column('skill_name', 'Topic', true, 'text', 'PropSkills');
        $this->mapperlib->add_column('level', 'Grade', true);
        $this->mapperlib->add_column('type', 'Type', false);
        $this->mapperlib->add_column('text', 'Text', false);
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
            'data-target' => '#editQuestionAdmin'
        ));

        $this->mapperlib->add_order_by('subject_name', 'Subject');
        $this->mapperlib->add_order_by('skill_name', 'Topic');
        $this->mapperlib->add_order_by('level', 'Grade');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('question/index');

        $this->mapperlib->set_default_order(PropQuestionPeer::QUESTION_ID, Criteria::ASC);

    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('question/index/' . $uri);
        }

        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);
        $data->count_questions = $this->question_model->getFoundRows();

        $data->content = $this->prepareView('x_question', 'home', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

//    public function save(){
//        /*
//         * get type of question
//         * */
//        $type = $this->input->post('type');
//
//        /*
//         * validation part - answers
//         * */
//        $multiple_choice = $this->input->post('multiple_choice');
//        switch ($multiple_choice) {
//            case '4_quest':
//                for ($i = 1; $i <= 4; $i++) {
//                    $this->form_validation->set_rules('four_answer[' . $i . ']', 'four_answer ' . $i . ' is required', 'required|trim');
//                }
//                break;
//            case '8_quest':
//                for ($i = 1; $i <= 8; $i++) {
//                    $this->form_validation->set_rules('eight_answer[' . $i . ']', 'Answer ' . $i . ' is required', 'required|trim');
//                }
//                break;
//        }
//        switch($type){
//            case 'calculator':
//                $this->form_validation->set_rules('calculator_correct_text','Correct calculation','required|trim');
//                break;
//            case 'text':
//                $this->form_validation->set_rules('correct_text','Correct text','required|trim');
//                break;
//            case 'order_slider':
//                $this->form_validation->set_rules('order_slider_correct','Correct','required|trim');
//
//                foreach($this->input->post('order_slider') as $k=>$v){
//                    $this->form_validation->set_rules('order_slider['.$k.']','Answer '.$k,'required|trim');
//                }
//                break;
//        }
//
//        if ($this->form_validation->run('question_global') === false || $this->form_validation->run() === false) {
//            redirect();
//        }
//
//        /*
//         * get id if request is for edit question
//         * */
//        $id = $this->input->post('id');
//
//        /*
//         *  create object to save data
//         * */
//        $data = new stdClass();
//
//
//        $data->subject_id = intval($this->input->post('subject_id'));
//        $data->skill_id = intval($this->input->post('skill_id'));
//        $data->level = intval($this->input->post('level'));
//        $data->type = $this->input->post('type');
//        $data->text = $this->input->post('text');
//
//        /*
//         * get image as blob if exist
//         * */
//        if (empty($_FILES) === false && $_FILES['image']['size'] > 0) {
//            $fp = fopen($_FILES['image']['tmp_name'], 'r');
//            $data->image = base64_encode(fread($fp, filesize($_FILES['image']['tmp_name'])));
//            fclose($fp);
//            $data->image_type = $_FILES['image']['type'];
//        }
//
//        /*
//         * prepare data for true/false question type
//         * */
//        if ($multiple_choice === 'true/false') {
//            $data->correct_text = $this->input->post('true_false');
//        }
//
//        /*
//         * prepare data for 4_quest type
//         * */
//        if ($multiple_choice === '4_quest') {
//            foreach ($this->input->post('four_answer') as $k => $v) {
//                $data->four_answer[$k]['answer'] = $v;
//                if ($k === intval($this->input->post('correct_four_answer'))) {
//                    $data->four_answer[$k]['correct'] = 'true';
//                }
//            }
//            /*
//            * get images as blob if exist
//            * */
//
//            if (empty($_FILES['four_image_answer']) === false && $_FILES['four_image_answer']['size'] > 0) {
//                foreach($_FILES['four_image_answer']['tmp_name'] as $b=>$n){
//                    if(empty($n) === false){
//                        $fp = fopen($n, 'r');
//                        $data->four_answer[$b]['image'] = base64_encode(fread($fp, filesize($n)));
//                        fclose($fp);
//                    }
//                }
//            }
//            $data->correct_choice_id = intval($this->input->post('correct_four_answer'));
//        }
//         /*
//         * prepare for 8_quest type
//         * */
//        else if ($multiple_choice === '8_quest') {
//            foreach ($this->input->post('eight_answer') as $k => $v) {
//                $data->eight_answer[$k]['answer'] = $v;
//                if ($k === intval($this->input->post('correct_eight_answer'))) {
//                    $data->eight_answer[$k]['correct'] = 'true';
//                }
//            }
//            /*
//            * get images as blob if exist
//            * */
//
//            if (empty($_FILES['eight_image_answer']) === false && $_FILES['eight_image_answer']['size'] > 0) {
//                foreach($_FILES['eight_image_answer']['tmp_name'] as $b=>$n){
//                    if(empty($n) === false){
//                        $fp = fopen($n, 'r');
//                        $data->eight_answer[$b]['image'] = base64_encode(fread($fp, filesize($n)));
//                        fclose($fp);
//                    }
//                }
//            }
//            $data->correct_choice_id = intval($this->input->post('correct_eight_answer'));
//        }
//        /*
//         * prepare for calculator type
//         * */
//        if ($type === 'calculator') {
//            $data->correct_text = $this->input->post('calculator_correct_text');
//        } else if ($type === 'text') {
//            $data->correct_text = $this->input->post('correct_text');
//        }
//        /*
//         * prepare for order_slider type
//         * */
//        else if($type === 'order_slider'){
//            $data->correct_text = $this->input->post('order_slider_correct');
//
//            foreach($this->input->post('order_slider') as $k=>$v){
//                $data->order_slider[$k]['answer'] = $v;
//            }
//        }
//
//        $this->question_model->save($data, $id);
//
//        redirect('question');
//    }

    public function save_question_type_1(){
        $challenge_id = $this->input->post('challenge_id');
        $question_id = $this->input->post('question_id');

        if($this->form_validation->run('question_type_1') === false || empty($challenge_id) === true){
            redirect();
        }
        $challenge_data = $this->challenge_question_model->get_challenge_data($challenge_id);

//        var_dump($challenge_data);

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

        redirect('question/');
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

        redirect('question/');
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
        $question_image_link = X_ADMIN_UPLOAD_PATH . '/'. $this->input->post('question_type_3_image');

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

        redirect('question/');
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
                $img_link = X_ADMIN_UPLOAD_PATH . '/'. $v;
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

        redirect('question/');
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

        $question_image_link = X_ADMIN_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->input->post('question_type_5_question_image');

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
                $img_link = X_ADMIN_UPLOAD_PATH . DIRECTORY_SEPARATOR. $v;
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

        redirect('question/');
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

        redirect('question/');
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
        $question->correct_text = intval($this->input->post('question_type_7_answer'));
        $ch = $this->challenge_question_model->save_question_7_type($question,$challenge_id,$question_id);

        redirect('question/');
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
        $question_image_link = X_ADMIN_UPLOAD_PATH . '/'. $this->input->post('question_type_8_question_image');

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

        redirect('question/');
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
        $question_image_link    = X_ADMIN_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->input->post('question_type_9_question_image');

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

        redirect('question/');
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

    public function upload_image(){
        $image = $this->pluploadlib_admin->process_upload();
        $out = array(
            'url' => config_item('upload_url').'/'.$image,
            'image_name' => $image
        );
        $this->output->set_output(trim($image));
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

        $challenge = $this->challenge_question_model->get_challenge_by_question_id($question_id);
        $out['challenge_id'] = $challenge->getChallengeId();

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
        }

        return $out;
    }

    public function ajax_get_type_list()
    {
        $list = array(
            'multiple_choice',
            'order_slider',
            'calculator',
            'text'
        );
        $this->output->set_output(json_encode($list));
    }

    public function ajax_get_multiple_choice_list()
    {
        $list = array(
            'true/false',
            '4_quest',
            '8_quest',
        );
        $this->output->set_output(json_encode($list));
    }

    public function ajax($id)
    {
        $question = $this->question_model->get_question_by_id($id);

        if (empty($question) === false) {
            $output = new stdClass();
            $output->question_id = $question->getQuestionId();
            $output->subject_id = $question->getSubjectId();
            $output->skill_id = $question->getSkillId();
            $output->level = $question->getLevel();
            $output->type = $question->getType();
            $output->text = $question->getText();

            $output->image = false;


            $correct_choice_id = $question->getCorrectChoiceId();
            if (empty($correct_choice_id) === true) {
                $output->correct_choice_id = null;
            } else {
                $output->correct_choice_id = $correct_choice_id;
                $choice = $this->question_model->get_choice_by_id($correct_choice_id);
                $output->correct_choice_text = $choice->getText();
            }
            $output->correct_text = $question->getCorrectText();

            $choices = $this->question_model->get_choices_by_question_id($id);

            if (empty($choices) === false) {
                $output->no_of_choices = count($choices);
                if ($output->no_of_choices > 0) {
                    foreach ($choices as $k => $v) {
                        $output->question_answers[$k] = $v->getText();
                        $output->choice_id[$k] = $v->getChoiceId();
                    }
                }
            }
            $this->output->set_header('Content-type: image/jpg');
            $this->output->set_output(json_encode($output));
        }
    }

    /*
     * Function for getting list of challenges
     * @return: list of challenges (challnge_id and challenge_name)
     * */
    public function ajax_get_challenges(){
        $challenges = $this->question_model->get_all_challenges();

        $out = array();

        foreach($challenges as $challenge=>$val){
            $out[$challenge]['challenge_id'] = $val->getChallengeId();
            $out[$challenge]['challenge_name'] = $val->getName();
        }

        $this->output->set_output(json_encode($out));
    }

    /*
    * validation function for save function
    * */

    public function ajax_validation(){

        $error = array();
        $multiple_choice = $this->input->post('multiple_choice');
        $type = $this->input->post('type');

        $this->form_validation->set_error_delimiters('','');
        $this->form_validation->run('question_global');

        if(form_error('subject_id') != '')
            $error['subject_id'] = form_error('subject_id');
        if(form_error('skill_id') != '')
            $error['skill_id'] = form_error('skill_id');
        if(form_error('level') != '')
            $error['level'] = form_error('level');
        if(form_error('type') != '')
            $error['type'] = form_error('type');
        if(form_error('text') != '')
            $error['text'] = form_error('text');

        switch ($multiple_choice) {
            case '4_quest':
                for ($i = 1; $i <= 4; $i++) {
                    $this->form_validation->set_rules('four_answer[' . $i . ']', 'Answer ' . $i, 'required|trim');
                    $this->form_validation->set_rules('correct_four_answer','correct_four_answer','required|trim');
                }
            break;
            case '8_quest':
                for ($i = 1; $i <= 8; $i++) {
                    $this->form_validation->set_rules('eight_answer[' . $i . ']', 'Answer ' . $i, 'required|trim');
                    $this->form_validation->set_rules('correct_eight_answer','correct_eight_answer','required|trim');
                }
                    break;
            case 'true/false':
                $this->form_validation->set_rules('true_false', 'Select', 'required|trim');
            break;
        }

        switch($type){
            case 'calculator':
                $this->form_validation->set_rules('calculator_correct_text','Correct calculation','required|trim');
            break;
            case 'text':
                $this->form_validation->set_rules('correct_text','Correct text','required|trim');
            break;
            case 'order_slider':
                $this->form_validation->set_rules('order_slider_correct','Correct','required|trim');

                foreach($this->input->post('order_slider') as $k=>$v){
                    $this->form_validation->set_rules('order_slider['.$k.']','Answer '.$k,'required|trim');
                }
            break;
        }
        if ($this->form_validation->run() === false) {
            switch ($multiple_choice) {
                case '4_quest':
                    for ($i = 1; $i <= 4; $i++) {
                        if(form_error('four_answer['.$i.']') != '')
                            $error['four_answer'][$i] = form_error('four_answer['.$i.']');
                    }
                    if(form_error('correct_four_answer') != '')
                    $error['four_answer']['correct_four_answer'] = 'Select correct answer';
                break;
                case '8_quest':
                    for ($i = 1; $i <= 8; $i++) {
                        if(form_error('eight_answer['.$i.']') != '')
                            $error['eight_answer'][$i] = form_error('eight_answer['.$i.']');
                        }
                        if(form_error('correct_eight_answer') != '')
                            $error['correct_eight_answer'] = 'Select correct answer';
                break;
                    case 'true/false':
                        if(form_error('true_false') != '')
                            $error['true_false'] = 'Select correct answer';
                break;
            }
            switch($type){
                case 'calculator':
                    if(form_error('calculator_correct_text') != '')
                        $error['calculator_correct_text'] = form_error('calculator_correct_text');
                    break;
                case 'text':
                    if(form_error('correct_text') != '')
                        $error['correct_text'] = form_error('correct_text');
                    break;
                case 'order_slider':
                    if(form_error('order_slider_correct') != '')
                        $error['order_slider_correct'] = form_error('order_slider_correct');

                    foreach($this->input->post('order_slider') as $k=>$v){
                        if(form_error('order_slider['.$k.']') != '')
                            $error['order_slider'][] = form_error('order_slider['.$k.']');
                    }
                    break;
            }
        }

        if($error === null){
            $error['passed'] = true;
        }else{
            $this->output->set_status_header('400');
        }

        $this->output->set_output(json_encode($error));
    }







    /*
    * function to display question image
    * @params: $question_id of student
    * @output: image
    * */
    public function display_question_image($question_id = false){
        $content = null;
        if($question_id){
            $image = $this->question_model->get_question_image($question_id);
            $this->output->set_header('Content-type: image/png');
            $this->output->set_output(base64_decode($image['image']));
        }
    }
    /*
    * function to display choice image
    * @params: $choice_id of student
    * @output: image
    * */
    public function display_question_choice_image($choice_id = false){
        $content = null;
        if($choice_id){
            $image = $this->question_model->get_question_image($choice_id);
            $this->output->set_header('Content-type: image/png');
            $this->output->set_output(base64_decode($image['image']));
        }
    }

    public function display_choice_image($choice_id){

        $image = $this->challenge_question_model->display_question_choice_image($choice_id);
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image['image']));

    }

    public function get_challenge_id_by_question_id($question_id){

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

}