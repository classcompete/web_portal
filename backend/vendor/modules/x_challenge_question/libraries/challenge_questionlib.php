<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/17/13
 * Time: 11:51 AM
 * To change this template use File | Settings | File Templates.
 */
class Challenge_questionlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_challenge_question/challenge_question_model');
        $this->ci->load->helper('x_challenge_question/challenge_question');
    }

    public function get_question_image_type($question_id){
        $question = $this->ci->challenge_question_model->get_question_by_id($question_id);


        if($question->getType() === 'keyboard'){
            return 'question_type_16';
        } else if($question->getType() === 'order_slider'){

            if($question->getImage() === null){
                return 'question_type_15';
            }else{
                return 'question_type_9';
            }
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
                    if($question->getImage() != null ){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() === null){
                                return 'question_type_10';
                            }else{
                                return 'question_type_11';
                            }
                        }
                    } else {
                        foreach($question_choices as $choice=>$val) {
                            if ($val->getImage() === null) {
                                if ($question->getLargeSpace() === PropQuestionPeer::LARGE_SPACE_YES) {
                                    return 'question_type_13';
                                } else {
                                    return 'question_type_1';
                                }
                            } else {
                                return 'question_type_12';
                            }
                        }

                    }
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
                                if ($question->getLargeSpace() === PropQuestionPeer::LARGE_SPACE_YES) {
                                    return 'question_type_14';
                                } else {
                                    return 'question_type_2';
                                }

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

        if($question->getType() === 'keyboard'){
            return nl2br("Keyboard \n &nbsp; \n &nbsp;");
        } else if($question->getType() === 'order_slider'){
            if($question->getImage() === null){
                return nl2br("Drag and Order \n &nbsp; \n &nbsp;");
            }else{
                return nl2br("Rank order question \n &nbsp; \n &nbsp;");
            }

        }
        else if($question->getCorrectChoiceId() === null){
            if($question->getImage() === null){
                return nl2br("Keypad Question \n User enters answer \n &nbsp;");
            }else{
                return nl2br("Keypad Question \n with picture \n User enters answer");
            }
        }else{
            /*
             * multiple choice
             * */
            $question_choices = $this->ci->challenge_question_model->get_choices_by_question_id($question_id);
            switch(count($question_choices)){
                case '2':
                    if($question->getImage() === null){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() !== null){
                                return nl2br("Standard 2 option \n Multiple Choice \n Image Answers");
                            }else{
                                if (strlen($val->getText()) > 50) {
                                    return nl2br("Long 2 option \n Multiple Choice \n &nbsp;");
                                } else {
                                    return nl2br("Standard 2 option \n Multiple Choice \n &nbsp;");
                                }
                            }
                        }

                    } else {
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() === null){
                                return nl2br("Standard 2 option \n Multiple Choice \n Image in Question");
                            }else{
                                return nl2br("Standard 2 option \n with picture \n Image Answers");
                            }
                        }

                    }

                    break;
                case '4' :
                    if($question->getImage() != null ){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() === null){
                                return nl2br("Standard 4 option \n Multiple Choice \n Image in Question");
                            }else{
                                return nl2br("Standard 4 option \n Multiple Choice \n Image Question and Answer");
                            }
                        }
                    }else if ($question->getImage() === null){
                        foreach($question_choices as $choice=>$val){
                            if($val->getImage() != null){
                                return nl2br("Standard 4 option \n Multiple Choice \n Image Answers");
                            }else{
                                if (strlen($val->getText()) > 50) {
                                    return nl2br("Long 4 option \n Multiple Choice \n &nbsp;");
                                } else {
                                    return nl2br("Standard 4 option \n Multiple Choice \n &nbsp;");
                                }

                            }
                        }
                    }
                    break;
                case '8':
                    return nl2br("Standard 8 option \n Multiple Choice \n &nbsp;");
                    break;
            }
        }



    }
    public function haveQuestions($challengeId){

        $this->ci->challenge_question_model->filterByChallengeId($challengeId);
        $challenges = $this->ci->challenge_question_model->getList();

        if(count($challenges) > 0) return true;

        return false;
    }
}