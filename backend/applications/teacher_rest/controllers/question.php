<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 11/1/13
 * Time: 4:33 PM
 */
class Question extends REST_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library('y_challenge_question/challenge_questionlib');
        $this->load->library('y_question/question_lib');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_get()
    {
        $challenge_id = $this->get('challenge');


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

        foreach ($questions as $k => $question) {
            $data->questions[$k]['question_name'] = $question->getText();
            $question_id = $question->getQuestionId();
            $data->questions[$k]['question_id'] = $question_id;
            $data->questions[$k]['question_title'] = $this->question_lib->get_question_title($question_id);
            $data->questions[$k]['question_image'] = $this->question_lib->get_question_image_type($question_id);
            $data->questions[$k]['question_type'] = $this->question_lib->get_question_type($question_id);

            $question_data = $this->get_question_details($question_id);
            $data->questions[$k]['data'] = $question_data;
        }

        $this->response($data);
    }

    public function id_get($id)
    {
//        $question = $this->question_model->get_question_by_id($id);

//        $data = new stdClass();
//        $data->question = array();


//        $data->question = array();
//
//        $data->question['question_name'] = $question->getText();
//        $question_id = $question->getQuestionId();
//        $data->question['question_id'] = $question_id;
//        $data->question['question_title'] = $this->question_lib->get_question_title($question_id);
//        $data->question['question_image'] = $this->question_lib->get_question_image_type($question_id);
//        $data->question['question_type'] = $this->question_lib->get_question_type($question_id);
//
//        $question_data = $this->get_question_details($question_id);
//        $data->question['data'] = $question_data;
//
//        $this->response($data);
        $question_details = $this->get_single_question_details($id);
        $this->response($question_details);
    }

    public function index_post()
    {
        $_POST = $this->post();
        $error = new stdClass();

        $challenge_id = $this->post('challenge');
        $question_type = $this->post('question_type');
//        $add_question = $this->post('add_question');
        $game_code = $this->post('game_code');

        $validation_name = $this->question_lib->get_validation_array_name_question($question_type, $game_code);

        if ($this->form_validation->run($validation_name) === false) {
            $error->question = REST_Form_validation::validation_errors_array();
            $this->response($error, 400);
        } else {
            $data = json_decode(json_encode($_POST), false);

            $new_question_id = $this->question_lib->prepare_and_save($data, $challenge_id);

            $out = new stdClass();
            $out->valdiation = true;
            $out->quesiton = $new_question_id;
            $this->response($out);
        }

//        $question = new stdClass();
//
//        /*
//         * Prepare question data for save
//         * */
//        switch ($question_type) {
//            case 'question_type_1':
//                if ($this->form_validation->run('question_type_1') === false) {
//                    $error->question = REST_Form_validation::validation_errors_array();
//                    $this->response($error, 400);
//                }
//                $question->question_type = $question_type;
//                $question->text = $this->post('question_type_1_question');
//                $question->type = 'multiple_choice';
//
//                $question->question_type_1[1]['answer'] = $this->post('question_type_1_answer_1');
//                $question->question_type_1[2]['answer'] = $this->post('question_type_1_answer_2');
//                foreach ($question->question_type_1 as $key => $val) {
//                    if ($key === intval($this->post('question_type_1_correct'))) {
//                        $question->question_type_1[$key]['correct'] = 'true';
//                    }
//                }
//                break;
//            case 'question_type_2':
//                if ($this->form_validation->run('question_type_2') === false) {
//                    $error->question = REST_Form_validation::validation_errors_array();
//                    $this->response($error, 400);
//                }
//                $question->question_type = $question_type;
//                $question->text = $this->post('question_type_2_question');
//                $question->type = 'multiple_choice';
//
//                $question->question_type_2[1]['answer'] = $this->post('question_type_2_answer_1');
//                $question->question_type_2[2]['answer'] = $this->post('question_type_2_answer_2');
//                $question->question_type_2[3]['answer'] = $this->post('question_type_2_answer_3');
//                $question->question_type_2[4]['answer'] = $this->post('question_type_2_answer_4');
//                foreach ($question->question_type_2 as $key => $vval) {
//                    if ($key === intval($this->post('question_type_2_correct'))) {
//                        $question->question_type_2[$key]['correct'] = 'true';
//                    }
//                }
//
//                break;
//            case 'question_type_3':
//                $question_image_link = X_TEACHER_UPLOAD_PATH . '/' . $this->input->post('question_type_3_image');
//
//                if ($this->form_validation->run('question_type_3') === false) {
//                    redirect();
//                }
//                $question->text = $this->input->post('question_type_3_question');
//                $question->type = 'multiple_choice';
//                foreach ($this->input->post('question_type_3_answer') as $k => $v) {
//                    $question->question_type_3[$k]['answer'] = $v;
//                    if ($k === intval($this->input->post('question_type_3_correct'))) {
//                        $question->question_type_3[$k]['correct'] = 'true';
//                    }
//                }
//
//                $fp = fopen($question_image_link, 'r');
//                $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
//                fclose($fp);
//
//                break;
//            case 'question_type_4':
//                if ($this->form_validation->run('question_type_4') === false) {
//                    redirect();
//                }
//                $question->text = $this->input->post('question_type_4_question');
//                $question->type = 'multiple_choice';
//                foreach ($this->input->post('question_type_4_image') as $k => $v) {
//                    $img_link = X_TEACHER_UPLOAD_PATH . '/' . $v;
//                    $fp = fopen($img_link, 'r');
//
//                    $question->question_type_4[$k]['answer'] = base64_encode(fread($fp, filesize($img_link)));
//                    ;
//                    fclose($fp);
//                    if ($k === intval($this->input->post('question_type_4_correct'))) {
//                        $question->question_type_4[$k]['correct'] = 'true';
//                    }
//                }
//
//                break;
//            case 'question_type_5':
//                $question_image_link = X_TEACHER_UPLOAD_PATH . '/' . $this->input->post('question_type_5_question_image');
//
//                if ($this->form_validation->run('question_type_5') === false) {
//                    redirect();
//                }
//                $question->text = $this->input->post('question_type_5_question');
//                $question->type = 'multiple_choice';
//                foreach ($this->input->post('question_type_5_answer_image') as $k => $v) {
//                    $img_link = X_TEACHER_UPLOAD_PATH . '/' . $v;
//                    $fp = fopen($img_link, 'r');
//
//                    $question->question_type_5[$k]['answer'] = base64_encode(fread($fp, filesize($img_link)));
//                    fclose($fp);
//                    if ($k === intval($this->input->post('question_type_5_correct'))) {
//                        $question->question_type_5[$k]['correct'] = 'true';
//                    }
//                }
//                $fp = fopen($question_image_link, 'r');
//                $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
//                fclose($fp);
//                break;
//            case 'question_type_6':
//                if ($this->form_validation->run('question_type_6') === false) {
//                    $error->question = REST_Form_validation::validation_errors_array();
//                    $this->response($error, 400);
//                }
//                $question->text = $this->input->post('question_type_6_question');
//                $question->type = 'multiple_choice';
//                foreach ($this->input->post('question_type_6_answer') as $k => $v) {
//                    $question->question_type_6[$k]['answer'] = $v;
//                    if ($k === intval($this->input->post('question_type_6_correct'))) {
//                        $question->question_type_6[$k]['correct'] = 'true';
//                    }
//                }
//
//                break;
//            case 'question_type_7':
//                if ($this->form_validation->run('question_type_7') === false) {
//                    redirect();
//                }
//
//                $question->text = $this->input->post('question_type_7_question');
//                $question->type = 'calculator';
//                $question->correct_text = $this->input->post('question_type_7_answer');
//                break;
//            case 'question_type_8':
//                $question_image_link = X_TEACHER_UPLOAD_PATH . '/' . $this->input->post('question_type_8_question_image');
//
//                if ($this->form_validation->run('question_type_8') === false) {
//                    redirect();
//                }
//                $question->text = $this->input->post('question_type_8_question');
//                $question->correct_text = $this->input->post('question_type_8_answer');
//                $question->type = 'calculator';
//                $fp = fopen($question_image_link, 'r');
//                $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
//                fclose($fp);
//                break;
//            case 'question_type_9':
//                if ($this->form_validation->run('question_type_9') === false) {
//                    redirect();
//                }
//
//                $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->input->post('question_type_9_question_image');
//                $question->text = $this->input->post('question_type_9_question');
//                $question->type = 'order_slider';
//
//                $fp = fopen($question_image_link, 'r');
//                $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
//                fclose($fp);
//
//                $question->correct_text = $this->input->post('question_type_9_correct_text');
//
//                foreach ($this->input->post('question_type_9_answer') as $k => $v) {
//                    $question->answer[$k]['answer'] = $v;
//                }
//
//                break;
//        }

//        $question_saved = $this->question_model->save($question, $challenge_id);
    }

    public function index_put()
    {
        $_POST = $this->put();
//        var_dump($_POST);
        $error = new stdClass();
        $challenge_id = $this->put('challenge');
        $question_type = $this->put('question_type');
        $question_id = $this->put('question_id');
        $game_code = $this->put('game_code');

        if (empty($question_type) === true) {
            $this->response(array("question_type" => "The Question Type field is required."));
        } else {

            $validation_name = $this->question_lib->get_validation_array_name_question($question_type, $game_code);
            $validation_name .= '_edit';

            $question = new stdClass();

            /*
             * Prepare question data for save
             * */
            if ($this->form_validation->run($validation_name) === false) {
                $error->question = REST_Form_validation::validation_errors_array();
                $this->response($error, 400);
            } else {
                $question->question_type = $question_type;

                switch ($question_type) {
                    case 'question_type_1':
                        $question->text = $this->put('question_type_1_question');
                        $question->type = 'multiple_choice';

                        $question->question_type_1[1]['answer'] = $this->put('question_type_1_answer_1');
                        $question->question_type_1[2]['answer'] = $this->put('question_type_1_answer_2');

                        $question->question_type_1[intval($this->put('question_type_1_correct'))]['correct'] = 'true';
                        break;
                    case 'question_type_2':
//                        $question->question_type = $question_type;
                        $question->text = $this->put('question_type_2_question');
                        $question->type = 'multiple_choice';

                        $question->question_type_2[1]['answer'] = $this->put('question_type_2_answer_1');
                        $question->question_type_2[2]['answer'] = $this->put('question_type_2_answer_2');
                        $question->question_type_2[3]['answer'] = $this->put('question_type_2_answer_3');
                        $question->question_type_2[4]['answer'] = $this->put('question_type_2_answer_4');

                        $question->question_type_2[intval($this->put('question_type_2_correct'))]['correct'] = 'true';

                        break;
                    case 'question_type_3':
                        $question->text = $this->put('question_type_3_question');
                        $question->type = 'multiple_choice';

                        $question->question_type_3[1]['answer'] = $this->put('question_type_3_answer_1');
                        $question->question_type_3[2]['answer'] = $this->put('question_type_3_answer_2');
                        $question->question_type_3[3]['answer'] = $this->put('question_type_3_answer_3');
                        $question->question_type_3[4]['answer'] = $this->put('question_type_3_answer_4');

                        $question->question_type_3[intval($this->put('question_type_3_correct'))]['correct'] = 'true';

//                        foreach ($this->input->put('question_type_3_answer') as $k => $v) {
//                            $question->question_type_3[$k]['answer'] = $v;
////                            if ($k === intval($this->input->put('question_type_3_correct'))) {
////                                $question->question_type_3[$k]['correct'] = 'true';
////                            }
//                        }

                        $qt3_image = $this->put('question_type_3_image');
                        if (empty($qt3_image) === false){
                            $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt3_image;

                            $fp = fopen($question_image_link, 'r');
                            $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
                            fclose($fp);
                        }

                        break;
                    case 'question_type_4':
                        $question->text = $this->put('question_type_4_question');
                        $question->type = 'multiple_choice';

                        $qt4a1_image = $this->put('question_type_4_image_1');
                        $qt4a2_image = $this->put('question_type_4_image_2');
                        $qt4a3_image = $this->put('question_type_4_image_3');
                        $qt4a4_image = $this->put('question_type_4_image_4');

                        if (empty($qt4a1_image) === false){
                            $img_link_1 = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt4a1_image;

                            $fp1 = fopen($img_link_1, 'r');
                            $question->question_type_4[1]['answer'] = base64_encode(fread($fp1, filesize($img_link_1)));
                            fclose($fp1);
                        } else {
                            $question->question_type_4[1]['answer'] = null;
                        }

                        if (empty($qt4a2_image) === false){
                            $img_link_2 = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt4a2_image;

                            $fp2 = fopen($img_link_2, 'r');
                            $question->question_type_4[2]['answer'] = base64_encode(fread($fp2, filesize($img_link_2)));
                            fclose($fp2);
                        } else {
                            $question->question_type_4[2]['answer'] = null;
                        }

                        if (empty($qt4a3_image) === false){
                            $img_link_3 = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt4a3_image;

                            $fp3 = fopen($img_link_3, 'r');
                            $question->question_type_4[3]['answer'] = base64_encode(fread($fp3, filesize($img_link_3)));
                            fclose($fp3);
                        } else {
                            $question->question_type_4[3]['answer'] = null;
                        }

                        if (empty($qt4a4_image) === false){
                            $img_link_4 = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt4a4_image;

                            $fp4 = fopen($img_link_4, 'r');
                            $question->question_type_4[4]['answer'] = base64_encode(fread($fp4, filesize($img_link_4)));
                            fclose($fp4);
                        } else {
                            $question->question_type_4[4]['answer'] = null;
                        }

                        $question->question_type_4[intval($this->put('question_type_4_correct'))]['correct'] = 'true';

//                        foreach ($this->input->put('question_type_4_image') as $k => $v) {
//                            $img_link = X_TEACHER_UPLOAD_PATH . '/' . $v;
//                            $fp = fopen($img_link, 'r');
//
//                            $question->question_type_4[$k]['answer'] = base64_encode(fread($fp, filesize($img_link)));
//                            fclose($fp);
//                            if ($k === intval($this->input->put('question_type_4_correct'))) {
//                                $question->question_type_4[$k]['correct'] = 'true';
//                            }
//                        }


                        break;
                    case 'question_type_5':
                        $question->text = $this->put('question_type_5_question');
                        $question->type = 'multiple_choice';

                        $qt5q_image = $this->put('question_type_5_question_image');

                        if (empty($qt5q_image) === false){
                            $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt5q_image;

                            $fp = fopen($question_image_link, 'r');
                            $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
                            fclose($fp);
                        }

                        $qt5a1_image = $this->put('question_type_5_answer_image_1');
                        $qt5a2_image = $this->put('question_type_5_answer_image_2');
                        $qt5a3_image = $this->put('question_type_5_answer_image_3');
                        $qt5a4_image = $this->put('question_type_5_answer_image_4');

                        if (empty($qt5a1_image) === false){
                            $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt5a1_image;
                            $fp = fopen($img_link, 'r');

                            $question->question_type_5[1]['answer'] = base64_encode(fread($fp, filesize($img_link)));
                            fclose($fp);
                        } else {
                            $question->question_type_5[1]['answer'] = null;
                        }

                        if (empty($qt5a2_image) === false){
                            $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt5a2_image;
                            $fp = fopen($img_link, 'r');

                            $question->question_type_5[2]['answer'] = base64_encode(fread($fp, filesize($img_link)));
                            fclose($fp);
                        } else {
                            $question->question_type_5[2]['answer'] = null;
                        }

                        if (empty($qt5a3_image) === false){
                            $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt5a3_image;
                            $fp = fopen($img_link, 'r');

                            $question->question_type_5[3]['answer'] = base64_encode(fread($fp, filesize($img_link)));
                            fclose($fp);
                        } else {
                            $question->question_type_5[3]['answer'] = null;
                        }

                        if (empty($qt5a4_image) === false){
                            $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt5a4_image;
                            $fp = fopen($img_link, 'r');

                            $question->question_type_5[4]['answer'] = base64_encode(fread($fp, filesize($img_link)));
                            fclose($fp);
                        } else {
                            $question->question_type_5[4]['answer'] = null;
                        }

                        $question->question_type_5[intval($this->put('question_type_5_correct'))]['correct'] = 'true';

//                        $answer_images = $this->put('question_type_5_answer_image');
//                        foreach ($answer_images as $k => $v) {
//                            $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $v;
//                            $fp = fopen($img_link, 'r');
//
//                            $question->question_type_5[$k]['answer'] = base64_encode(fread($fp, filesize($img_link)));
//                            ;
//                            fclose($fp);
//                            if ($k === intval($this->put('question_type_5_correct'))) {
//                                $question->question_type_5[$k]['correct'] = 'true';
//                            }
//                        }
                        break;
                    case 'question_type_6':
                        $question->text = $this->put('question_type_6_question');
                        $question->type = 'multiple_choice';

                        $question->question_type_6[1]['answer'] = $this->put('question_type_6_answer_1');
                        $question->question_type_6[2]['answer'] = $this->put('question_type_6_answer_2');
                        $question->question_type_6[3]['answer'] = $this->put('question_type_6_answer_3');
                        $question->question_type_6[4]['answer'] = $this->put('question_type_6_answer_4');
                        $question->question_type_6[5]['answer'] = $this->put('question_type_6_answer_5');
                        $question->question_type_6[6]['answer'] = $this->put('question_type_6_answer_6');
                        $question->question_type_6[7]['answer'] = $this->put('question_type_6_answer_7');
                        $question->question_type_6[8]['answer'] = $this->put('question_type_6_answer_8');

                        $question->question_type_6[intval($this->put('question_type_6_correct'))]['correct'] = 'true';

                        break;
                    case 'question_type_7':
                        $question->text = $this->put('question_type_7_question');
                        $question->type = 'calculator';
                        $question->correct_text = $this->put('question_type_7_answer');
                        break;
                    case 'question_type_8':
                        $question->text = $this->put('question_type_8_question');
                        $question->correct_text = $this->put('question_type_8_answer');
                        $question->type = 'calculator';

                        $qt8_image = $this->put('question_type_8_question_image');
                        if (empty($qt8_image) === false){
                            $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $qt8_image;
                            $fp = fopen($question_image_link, 'r');

                            $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
                            fclose($fp);
                        }
                        break;
                    case 'question_type_9':
                        $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $this->put('question_type_9_question_image');
                        $question->text = $this->put('question_type_9_question');
                        $question->type = 'order_slider';

                        $fp = fopen($question_image_link, 'r');
                        $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
                        fclose($fp);

                        $question->correct_text = $this->put('question_type_9_correct_text');

                        foreach ($this->put('question_type_9_answer') as $k => $v) {
                            $question->answer[$k]['answer'] = $v;
                        }

                        break;
                }
            }

            $question_saved = $this->question_model->save($question, intval($challenge_id), intval($question_id));

            $out = new stdClass();
            $out->valdiation = true;
            $this->response($out);
        }
    }

    public function id_delete($id)
    {
        $deleted = $this->question_model->delete($id);

        $this->response($deleted);
    }

    private function get_question_details($question_id)
    {
        $question_details = $this->question_model->get_question_by_id($question_id);

        $question_type = $this->question_lib->get_question_image_type($question_id);
        $out = array();
        $out['question_text'] = $question_details->getText();
        $out['question_type'] = $question_type;

        switch ($question_type) {
            case 'question_type_1':
                $question_choice = $this->question_model->get_choices_by_question_id($question_id);
                foreach ($question_choice as $choice => $val) {
                    $out['answers'][$choice]['text'] = $val->getText();
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_2':
                $question_choice = $this->question_model->get_choices_by_question_id($question_id);
                foreach ($question_choice as $choice => $val) {
                    $out['answers'][$choice]['text'] = $val->getText();
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_3':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->question_model->get_choices_by_question_id($question_id);
                foreach ($question_choice as $choice => $val) {
                    $out['answers'][$choice]['text'] = $val->getText();
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_4':
                $question_choice = $this->question_model->get_choices_by_question_id($question_id);
                foreach ($question_choice as $choice => $val) {
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_5':
                $out['question_image'] = $question_details->getQuestionId();
                $question_choice = $this->question_model->get_choices_by_question_id($question_id);
                foreach ($question_choice as $choice => $val) {
                    $out['answers'][$choice]['answer_image'] = $val->getChoiceId();
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        $out['answers'][$choice]['correct'] = true;
                    }
                }
                break;
            case 'question_type_6':
                $question_choice = $this->question_model->get_choices_by_question_id($question_id);
                foreach ($question_choice as $choice => $val) {
                    $out['answers'][$choice]['text'] = $val->getText();
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
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
                $question_choice = $this->question_model->get_choices_by_question_id($question_id);
                foreach ($question_choice as $choice => $val) {
                    $out['answers'][$choice]['text'] = $val->getText();
                }
                $out['correct_text'] = $question_details->getCorrectText();
                break;
        }

        return $out;
    }

    private function get_single_question_details($question_id)
    {
        $question_details = $this->question_model->get_question_by_id($question_id);
//        var_dump($question_details);

        $question_type = $this->question_lib->get_question_image_type($question_id);
        $out = new stdClass();
        $out->question = new stdClass();
        $question_choices = $this->question_model->get_choices_by_question_id($question_id);
//        var_dump($question_choices);
        $out->question->question_type = $question_type;

        switch ($question_type) {
            case 'question_type_1':
                $out->question->question_type_1_question = $question_details->getText();

                $out->question->question_type_1_answer_1 = $question_choices[0]->getText();
                $out->question->question_type_1_answer_2 = $question_choices[1]->getText();

                foreach ($question_choices as $choice => $val) {
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        // +1 - hack for correct choice
                        $out->question->question_type_1_correct = $choice + 1;
                    }
                }
                break;
            case 'question_type_2':
                $out->question->question_type_2_question = $question_details->getText();

                $out->question->question_type_2_answer_1 = $question_choices[0]->getText();
                $out->question->question_type_2_answer_2 = $question_choices[1]->getText();
                $out->question->question_type_2_answer_3 = $question_choices[2]->getText();
                $out->question->question_type_2_answer_4 = $question_choices[3]->getText();

                foreach ($question_choices as $choice => $val) {
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        // +1 - hack for correct choice
                        $out->question->question_type_2_correct = $choice + 1;
                    }
                }
                break;
            case 'question_type_3':
                $out->question->question_type_3_question = $question_details->getText();

                $out->question->question_type_3_answer_1 = $question_choices[0]->getText();
                $out->question->question_type_3_answer_2 = $question_choices[1]->getText();
                $out->question->question_type_3_answer_3 = $question_choices[2]->getText();
                $out->question->question_type_3_answer_4 = $question_choices[3]->getText();

                foreach ($question_choices as $choice => $val) {
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        // +1 - hack for correct choice
                        $out->question->question_type_3_correct = $choice + 1;
                    }
                }
                $out->question->question_type_3_image_url = $this->config->item('images_url') . 'question_image/question/' . $question_details->getQuestionId();
                break;
            case 'question_type_4':
                $out->question->question_type_4_question = $question_details->getText();

                $out->question->question_type_4_image_1_url = $this->config->item('images_url') . 'question_choice_image/choice/' . $question_choices[0]->getChoiceId();
                $out->question->question_type_4_image_2_url = $this->config->item('images_url') . 'question_choice_image/choice/' . $question_choices[1]->getChoiceId();
                $out->question->question_type_4_image_3_url = $this->config->item('images_url') . 'question_choice_image/choice/' . $question_choices[2]->getChoiceId();
                $out->question->question_type_4_image_4_url = $this->config->item('images_url') . 'question_choice_image/choice/' . $question_choices[3]->getChoiceId();

                foreach ($question_choices as $choice => $val) {
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        // +1 - hack for correct choice
                        $out->question->question_type_4_correct = $choice + 1;
                    }
                }
                break;
            case 'question_type_5':
                $out->question->question_type_5_question = $question_details->getText();
                $out->question->question_type_5_question_image_url = $this->config->item('images_url') . 'question_image/question/' . $question_details->getQuestionId();

                $out->question->question_type_5_answer_image_1_url = $this->config->item('images_url') . 'question_choice_image/choice/' . $question_choices[0]->getChoiceId();
                $out->question->question_type_5_answer_image_2_url = $this->config->item('images_url') . 'question_choice_image/choice/' . $question_choices[1]->getChoiceId();
                $out->question->question_type_5_answer_image_3_url = $this->config->item('images_url') . 'question_choice_image/choice/' . $question_choices[2]->getChoiceId();
                $out->question->question_type_5_answer_image_4_url = $this->config->item('images_url') . 'question_choice_image/choice/' . $question_choices[3]->getChoiceId();

                foreach ($question_choices as $choice => $val) {
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        // +1 - hack for correct choice
                        $out->question->question_type_5_correct = $choice + 1;
                    }
                }
                break;
            case 'question_type_6':
                $out->question->question_type_6_question = $question_details->getText();

                $out->question->question_type_6_answer_1 = $question_choices[0]->getText();
                $out->question->question_type_6_answer_2 = $question_choices[1]->getText();
                $out->question->question_type_6_answer_3 = $question_choices[2]->getText();
                $out->question->question_type_6_answer_4 = $question_choices[3]->getText();
                $out->question->question_type_6_answer_5 = $question_choices[4]->getText();
                $out->question->question_type_6_answer_6 = $question_choices[5]->getText();
                $out->question->question_type_6_answer_7 = $question_choices[6]->getText();
                $out->question->question_type_6_answer_8 = $question_choices[7]->getText();

                foreach ($question_choices as $choice => $val) {
                    if ($val->getChoiceId() === $question_details->getCorrectChoiceId()) {
                        // +1 - hack for correct choice
                        $out->question->question_type_6_correct = $choice + 1;
                    }
                }
                break;
            case 'question_type_7':
                $out->question->question_type_7_question = $question_details->getText();

                $out->question->question_type_7_answer = $question_details->getCorrectText();
                break;
            case 'question_type_8':
                $out->question->question_type_8_question = $question_details->getText();

                $out->question->question_type_8_answer = $question_details->getCorrectText();
                $out->question->question_type_8_question_image_url = $this->config->item('images_url') . 'question_image/question/' . $question_details->getQuestionId();
                break;
            case 'question_type_9':
                $out->question->question_type_9_question = $question_details->getText();

                $out->question->question_type_9_answer_1 = $question_choices[0]->getText();
                $out->question->question_type_9_answer_2 = $question_choices[1]->getText();
                $out->question->question_type_9_answer_3 = $question_choices[2]->getText();
                $out->question->question_type_9_answer_4 = $question_choices[3]->getText();

                $out->question->question_type_9_question_image = $question_details->getQuestionId();

                foreach ($question_choices as $choice => $val) {
                    $out->question->question_type_9_correct = $choice;
                }
                $out->question->question_type_9_correct_text = $question_details->getCorrectText();
                break;
        }

        return $out;
    }
}
