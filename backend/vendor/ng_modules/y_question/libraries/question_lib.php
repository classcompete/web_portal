<?php
class Question_lib
{
    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('y_question/question_model');
        $this->ci->load->helper('y_question/question');
    }

    public function get_validation_array_name_challenge_question($question_type, $game_code){
        return $question_type . '_' . $game_code;
    }

    public function get_validation_array_name_question($question_type, $game_code){
        return $question_type . '_' . $game_code . '_question';
    }

    public function prepare_and_save($data, $challenge_id){

        $question = new stdClass();
        $question->question_type = $data->question_type;

        switch ($data->question_type) {
            case 'question_type_1':
                $question->text = $data->question_type_1_question;
                $question->type = 'multiple_choice';

                $question->question_type_1[1]['answer'] = $data->question_type_1_answer_1;
                $question->question_type_1[2]['answer'] = $data->question_type_1_answer_2;
                $question->question_type_1[intval($data->question_type_1_correct)]['correct'] = 'true';
                break;
            case 'question_type_2':
                $question->text = $data->question_type_2_question;
                $question->type = 'multiple_choice';

                $question->question_type_2[1]['answer'] = $data->question_type_2_answer_1;
                $question->question_type_2[2]['answer'] = $data->question_type_2_answer_2;
                $question->question_type_2[3]['answer'] = $data->question_type_2_answer_3;
                $question->question_type_2[4]['answer'] = $data->question_type_2_answer_4;
                $question->question_type_2[intval($data->question_type_2_correct)]['correct'] = 'true';
                break;
            case 'question_type_3':
                $question->text = $data->question_type_3_question;
                $question->type = 'multiple_choice';

                $question->question_type_3[1]['answer'] = $data->question_type_3_answer_1;
                $question->question_type_3[2]['answer'] = $data->question_type_3_answer_2;
                $question->question_type_3[3]['answer'] = $data->question_type_3_answer_3;
                $question->question_type_3[4]['answer'] = $data->question_type_3_answer_4;
                $question->question_type_3[intval($data->question_type_3_correct)]['correct'] = 'true';

                $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $data->question_type_3_image;

                $fp = fopen($question_image_link, 'r');
                $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
                fclose($fp);
                break;
            case 'question_type_4':
                $question->text = $data->question_type_4_question;
                $question->type = 'multiple_choice';

                $images_array = array(
                    $data->question_type_4_image_1,
                    $data->question_type_4_image_2,
                    $data->question_type_4_image_3,
                    $data->question_type_4_image_4
                );

                foreach ($images_array as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $v;
                    $fp = fopen($img_link, 'r');

                    $question->question_type_4[$k + 1]['answer'] = base64_encode(fread($fp, filesize($img_link)));
                    fclose($fp);
                }
                $question->question_type_4[intval($data->question_type_4_correct)]['correct'] = 'true';

                break;
            case 'question_type_5':
                $question->text = $data->question_type_5_question;
                $question->type = 'multiple_choice';

                $images_array = array(
                    $data->question_type_5_answer_image_1,
                    $data->question_type_5_answer_image_2,
                    $data->question_type_5_answer_image_3,
                    $data->question_type_5_answer_image_4
                );

                foreach ($images_array as $k => $v) {
                    $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $v;
                    $fp = fopen($img_link, 'r');

                    $question->question_type_5[$k + 1]['answer'] = base64_encode(fread($fp, filesize($img_link)));
                    fclose($fp);
                }

                $question->question_type_5[intval($data->question_type_5_correct)]['correct'] = 'true';

                $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $data->question_type_5_question_image;
                $fp = fopen($question_image_link, 'r');
                $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
                fclose($fp);
                break;
            case 'question_type_6':
                $question->text = $data->question_type_6_question;
                $question->type = 'multiple_choice';

                $question->question_type_6[1]['answer'] = $data->question_type_6_answer_1;
                $question->question_type_6[2]['answer'] = $data->question_type_6_answer_2;
                $question->question_type_6[3]['answer'] = $data->question_type_6_answer_3;
                $question->question_type_6[4]['answer'] = $data->question_type_6_answer_4;
                $question->question_type_6[5]['answer'] = $data->question_type_6_answer_5;
                $question->question_type_6[6]['answer'] = $data->question_type_6_answer_6;
                $question->question_type_6[7]['answer'] = $data->question_type_6_answer_7;
                $question->question_type_6[8]['answer'] = $data->question_type_6_answer_8;
                $question->question_type_6[intval($data->question_type_6_correct)]['correct'] = 'true';
                break;
            case 'question_type_7':
                $question->text = $data->question_type_7_question;
                $question->type = 'calculator';

                $question->correct_text = $data->question_type_7_answer;
                break;
            case 'question_type_8':
                $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $data->question_type_8_question_image;

                $question->text = $data->question_type_8_question;
                $question->correct_text = $data->question_type_8_answer;
                $question->type = 'calculator';

                $fp = fopen($question_image_link, 'r');
                $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
                fclose($fp);
                break;
            case 'question_type_9':
                $question_image_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $data->question_type_9_question_image;
                $question->text = $data->question_type_9_question;
                $question->type = 'order_slider';

                $fp = fopen($question_image_link, 'r');
                $question->image_thumb = base64_encode(fread($fp, filesize($question_image_link)));
                fclose($fp);

                $question->correct_text = $data->question_type_9_correct_text;

                $question->answer[1]['answer'] = $data->question_type_9_answer_1;
                $question->answer[2]['answer'] = $data->question_type_9_answer_2;
                $question->answer[3]['answer'] = $data->question_type_9_answer_3;
                $question->answer[4]['answer'] = $data->question_type_9_answer_4;
                break;
        }

        $qu = $this->ci->question_model->save($question, $challenge_id);
        return $qu->getQuestionId();
    }

    public function get_question_title($question_id){
        $question = $this->ci->challenge_question_model->get_question_by_id($question_id);
        $title = new stdClass();

        if($question->getType() === 'order_slider'){
            $title->title = 'Rank order question';
            return $title;
        }
        else if($question->getCorrectChoiceId() === null){
            if($question->getImage() === null){
                $title->title = 'Keypad Question';
                $title->sub_title = 'User enters answer';
                return $title;
            }else{
                $title->title = 'Keypad Question';
                $title->sub_title = 'with picture';
                $title->sub_title_two = 'User enters answer';
                return $title;
            }
        }else{
            /*
             * multiple choice
             * */
            $question_choices = $this->ci->challenge_question_model->get_choices_by_question_id($question_id);
            switch(count($question_choices)){
                case '2':
                    $title->title = 'Standard 2 option';
                    $title->sub_title = 'Multiple Choice';
                    return $title;
                    break;
                case '4' :
                    if($question->getImage() != null ){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() === null){
                                $title->title = 'Standard 4 option';
                                $title->sub_title = 'Multiple Choice';
                                $title->sub_title_two = 'Image in Question';
                                return $title;
                            }else{
                                $title->title = 'Standard 4 option';
                                $title->sub_title = 'Multiple Choice';
                                $title->sub_title_two = 'Image Question and Answer';
                                return $title;
                            }
                        }
                    }else if ($question->getImage() === null){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() != null){
                                $title->title = 'Standard 4 option';
                                $title->sub_title = 'Multiple Choice';
                                $title->sub_title_two = 'Image Answers';
                                return $title;
                            }else{
                                $title->title = 'Standard 4 option';
                                $title->sub_title = 'Multiple Choice';
                                return $title;
                            }
                        }
                    }
                    break;
                case '8':
                    $title->title = 'Standard 8 option';
                    $title->sub_title = 'Multiple Choice';
                    return $title;
                    break;
            }
        }



    }

    public function get_question_image_type($question_id){
        $question = $this->ci->challenge_question_model->get_question_by_id($question_id);


        if($question->getType() === 'order_slider'){
            return 'question_type_9';
        }
        else if($question->getCorrectChoiceId() === null){
            if($question->getImage() === null){
                return 'question_type_7';
            }else{
                return 'question_type_8';
            }
        }else{
            /*
             * multiple choice
             * */
            $question_choices = $this->ci->challenge_question_model->get_choices_by_question_id($question_id);
            switch(count($question_choices)){
                case '2':
                    return 'question_type_1';
                    break;
                case '4' :
                    if($question->getImage() != null ){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() === null){
                                return 'question_type_3';
                            }else{
                                return 'question_type_5';
                            }
                        }
                    }else if ($question->getImage() === null){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() != null){
                                return 'question_type_4';
                            }else{
                                return 'question_type_2';
                            }
                        }
                    }
                    break;
                case '8':
                    return 'question_type_6';
                    break;
            }
        }
    }

    public function get_question_type($question_id){
        $question = $this->ci->challenge_question_model->get_question_by_id($question_id);


        if($question->getType() === 'order_slider'){
            return 'question_type_9';
        }
        else if($question->getCorrectChoiceId() === null){
            if($question->getImage() === null){
                return 'question_type_7';
            }else{
                return 'question_type_8';
            }
        }else{
            /*
             * multiple choice
             * */
            $question_choices = $this->ci->challenge_question_model->get_choices_by_question_id($question_id);
            switch(count($question_choices)){
                case '2':
                    return 'question_type_1';
                    break;
                case '4' :
                    if($question->getImage() != null ){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() === null){
                                return 'question_type_3';
                            }else{
                                return 'question_type_5';
                            }
                        }
                    }else if ($question->getImage() === null){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() != null){
                                return 'question_type_4';
                            }else{
                                return 'question_type_2';
                            }
                        }
                    }
                    break;
                case '8':
                    return 'question_type_6';
                    break;
            }
        }



    }
}