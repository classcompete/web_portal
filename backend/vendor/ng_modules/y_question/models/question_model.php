<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/15/13
 * Time: 5:08 PM
 */
class Question_model extends CI_Model{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterSubjectName = null;
    private $filterSkillName = null;
    private $filterLevel = null;
    private $filterChallengeId = null;


    public function __construct(){
        parent::__construct();
    }
    public function save($data, $challenge_id, $id = null){

        $edit = false;

        if (empty($id) === true) {
            /*
            * Part to save question
            * */

            $challenge_data = $this->get_challenge_by_id($challenge_id);

            $question = new PropQuestion();
            $question->setSubjectId($challenge_data->getSubjectId());
            $question->setSkillId($challenge_data->getSkillId());
            $question->setLevel($challenge_data->getLevel());
            $question->setType($data->type);
            $question->setText($data->text);
            $question->setTopicId($challenge_data->getTopicId());

            if (isset($data->image_thumb) === true && empty($data->image_thumb) === false) {
                $question->setImage($data->image_thumb);
            }
            if (isset($data->correct_text) === true && empty($data->correct_text) === false) {
                $question->setCorrectText($data->correct_text);
            }
            $question->save();
            $question_id = $question->getQuestionId();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
            $question_id = $question->getQuestionId();

            $question->setText($data->text);

            $edit = true;

//            var_dump($question_id);
//            var_dump($question);
//
//            var_dump($data);
//            die();
        }

        switch($data->question_type){
            case 'question_type_1':
                if (isset($data->question_type_1) === true && empty($data->question_type_1) === false) {
                    if (count($data->question_type_1) === 2) {
                        foreach ($data->question_type_1 as $k => $v) {
                            if (isset($v['answer']) === true && empty($v['answer']) === false) {

                                if ($edit === true) {

                                    $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);

                                    $question_choice[$k - 1]->setText($v['answer']);
                                    $question_choice->save();

                                    /*
                                     * get choice_id for updating question table for correct answer
                                     * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice[$k - 1]->getChoiceId();
                                    }

                                } else {

                                    /*
                                    * insert new question choice if id is empty
                                    * */

                                    $question_choice = new PropQuestionChoice();
                                    $question_choice->setText($v['answer']);
                                    $question_choice->setQuestionId($question_id);
                                    $question_choice->save();

                                    /*
                                    * get choice_id for update question table for correct answer
                                    * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice->getChoiceId();
                                    }
                                }
                            }
                        }
                        /*
                       * update question table - correct_choice_id - to reference to correct question answer
                       * */

                        if (isset($question_choice_id) === true && empty($question_choice_id) === false) {
                            $question_update = PropQuestionQuery::create()->findOneByQuestionId($question_id);
                            $question_update->setCorrectChoiceId($question_choice_id);
                            $question_update->save();
                        }
                    }
                }
                break;
            case 'question_type_2':
                if (isset($data->question_type_2) === true && empty($data->question_type_2) === false) {
                    if (count($data->question_type_2) === 4) {
                        foreach ($data->question_type_2 as $k => $v) {
                            if (isset($v['answer']) === true && empty($v['answer']) === false) {

                                if ($edit === true) {
                                    $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                                    $question_choice[$k-1]->setText($v['answer']);
                                    $question_choice->save();

                                    /*
                                     * get choice_id for updating question table for correct answer
                                     * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice[$k-1]->getChoiceId();
                                    }
                                } else {
                                /*
                                * insert new question choice if id is empty
                                * */
                                    $question_choice = new PropQuestionChoice();
                                    $question_choice->setText($v['answer']);
                                    $question_choice->setQuestionId($question_id);
                                    $question_choice->save();

                                    /*
                                    * get choice_id for update question table for correct answer
                                    * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice->getChoiceId();
                                    }
                                }
                            }
                        }

                        /*
                        * update question table - correct_choice_id - to reference to correct question answer
                        * */

                        if (isset($question_choice_id) === true && empty($question_choice_id) === false) {
                            $question_update = PropQuestionQuery::create()->findOneByQuestionId($question_id);
                            $question_update->setCorrectChoiceId($question_choice_id);
                            $question_update->save();
                        }
                    }
                }
                break;
            case 'question_type_3':
                if (isset($data->question_type_3) === true && empty($data->question_type_3) === false) {

                    if (count($data->question_type_3) === 4) {
                        foreach ($data->question_type_3 as $k => $v) {
                            if (isset($v['answer']) === true && empty($v['answer']) === false) {

                                if ($edit === true) {
                                    $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                                    $question_choice[$k-1]->setText($v['answer']);

                                    // this part is unnecessary, right??
                                    if(isset($v['image']) === true && empty($v['image']) === false){
                                        $question_choice[$k-1]->setImage($v['image']);
                                    }
                                    $question_choice->save();

                                    // update question image
                                    if(isset($data->image_thumb) === true && empty($data->image_thumb) === false){
                                        $question->setImage($data->image_thumb);
                                    }

                                    /*
                                     * get choice_id for updating question table for correct answer
                                     * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice[$k-1]->getChoiceId();
                                    }
                                } else {
                                    /*
                                    * insert new question choice if id is empty
                                    * */

                                    $question_choice = new PropQuestionChoice();
                                    $question_choice->setText($v['answer']);
                                    if(isset($v['image']) === true && empty($v['image']) === false){
                                        $question_choice->setImage($v['image']);
                                    }
                                    $question_choice->setQuestionId($question_id);
                                    $question_choice->save();

                                    /*
                                    * get choice_id for update question table for correct answer
                                    * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice->getChoiceId();
                                    }
                                }
                            }
                        }

                        /*
                        * update question table - correct_choice_id - to reference to correct question answer
                        * */

                        if (isset($question_choice_id) === true && empty($question_choice_id) === false) {
                            $question_update = PropQuestionQuery::create()->findOneByQuestionId($question_id);
                            $question_update->setCorrectChoiceId($question_choice_id);
                            $question_update->save();
                        }
                    }
                }
                break;
            case 'question_type_4':
                if (isset($data->question_type_4) === true && empty($data->question_type_4) === false) {
                    if (count($data->question_type_4) === 4) {
                        foreach ($data->question_type_4 as $k => $v) {

                            if ($edit === true) {
                                $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);

                                if ($v['answer'] !== null) {
                                    $question_choice[$k - 1]->setImage($v['answer']);
                                    $question_choice->save();
                                }

                                /*
                                 * get choice_id for updating question table for correct answer
                                 * */
                                if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                    $question_choice_id = $question_choice[$k - 1]->getChoiceId();
                                }
                            } else {

                                if (isset($v['answer']) === true && empty($v['answer']) === false) {
                                    /*
                                    * insert new question choice if id is empty
                                    * */
                                    $question_choice = new PropQuestionChoice();
                                    $question_choice->setImage($v['answer']);
                                    $question_choice->setQuestionId($question_id);
                                    $question_choice->save();

                                    /*
                                    * get choice_id for update question table for correct answer
                                    * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice->getChoiceId();
                                    }
                                }
                            }
                        }

                        /*
                        * update question table - correct_choice_id - to reference to correct question answer
                        * */

                        if (isset($question_choice_id) === true && empty($question_choice_id) === false) {
                            $question_update = PropQuestionQuery::create()->findOneByQuestionId($question_id);
                            $question_update->setCorrectChoiceId($question_choice_id);
                            $question_update->save();
                        }
                    }
                }
                break;
            case 'question_type_5':
                if (isset($data->question_type_5) === true && empty($data->question_type_5) === false) {
                    if (count($data->question_type_5) === 4) {
                        foreach ($data->question_type_5 as $k => $v) {

                            if ($edit === true) {
                                $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);

                                // update question image
                                if(isset($data->image_thumb) === true && empty($data->image_thumb) === false){
                                    $question->setImage($data->image_thumb);
                                }

                                if ($v['answer'] !== null) {
                                    $question_choice[$k - 1]->setImage($v['answer']);
                                    $question_choice->save();
                                }

                                /*
                                 * get choice_id for updating question table for correct answer
                                 * */
                                if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                    $question_choice_id = $question_choice[$k-1]->getChoiceId();
                                }

                            } else {

                                if (isset($v['answer']) === true && empty($v['answer']) === false) {

                                    /*
                                     * insert new question choice if id is empty
                                     * */
                                    $question_choice = new PropQuestionChoice();
                                    $question_choice->setImage($v['answer']);
                                    $question_choice->setQuestionId($question_id);
                                    $question_choice->save();

                                    /*
                                    * get choice_id for update question table for correct answer
                                    * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice->getChoiceId();
                                    }
                                }
                            }
                        }

                        /*
                        * update question table - correct_choice_id - to reference to correct question answer
                        * */

                        if (isset($question_choice_id) === true && empty($question_choice_id) === false) {
                            $question_update = PropQuestionQuery::create()->findOneByQuestionId($question_id);
                            $question_update->setCorrectChoiceId($question_choice_id);
                            $question_update->save();
                        }
                    }
                }
                break;
            case 'question_type_6':
                if (isset($data->question_type_6) === true && empty($data->question_type_6) === false) {
                    if (count($data->question_type_6) === 8) {
                        foreach ($data->question_type_6 as $k => $v) {
                            if (isset($v['answer']) === true && empty($v['answer']) === false) {

                                if ($edit === true){
                                    $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                                    $question_choice[$k-1]->setText($v['answer']);
                                    $question_choice->save();

                                    /*
                                     * get choice_id for updating question table for correct answer
                                     * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice[$k-1]->getChoiceId();
                                    }
                                } else {
                                    /*
                                    * insert new question choice if id is empty
                                    * */
                                    $question_choice = new PropQuestionChoice();
                                    $question_choice->setText($v['answer']);
                                    $question_choice->setQuestionId($question_id);
                                    $question_choice->save();

                                    /*
                                    * get choice_id for update question table for correct answer
                                    * */
                                    if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                        $question_choice_id = $question_choice->getChoiceId();
                                    }
                                }
                            }
                        }

                        /*
                        * update question table - correct_choice_id - to reference to correct question answer
                        * */

                        if (isset($question_choice_id) === true && empty($question_choice_id) === false) {
                            $question_update = PropQuestionQuery::create()->findOneByQuestionId($question_id);
                            $question_update->setCorrectChoiceId($question_choice_id);
                            $question_update->save();
                        }
                    }
                }
                break;
            case 'question_type_7':
                if ($edit === true){

                    if (isset($data->correct_text) === true && empty($data->correct_text) === false) {
                        $question->setCorrectText($data->correct_text);
                    }
                    $question->save();
                }
                break;
            case 'question_type_8':
                if ($edit === true){

                    if (isset($data->correct_text) === true && empty($data->correct_text) === false) {
                        $question->setCorrectText($data->correct_text);
                    }

                    // update question image
                    if(isset($data->image_thumb) === true && empty($data->image_thumb) === false){
                        $question->setImage($data->image_thumb);
                    }

                    $question->save();
                }
                break;
            case 'question_type_9':
                if (isset($data->answer) === true && empty($data->answer) === false) {
                    if (count($data->answer) === 4) {
                        $correct_text_array =  explode(',',$data->correct_text);
                        $correct_choice_id_array = array();
                        foreach($data->answer as $k=>$v){
                            if (isset($v['answer']) === true && empty($v['answer']) === false) {
                                /*
                                * insert new question choice if id is empty
                                * */
                                if(empty($id) === true){
                                    $question_choice = new PropQuestionChoice();
                                    $question_choice->setText($v['answer']);
                                    $question_choice->setQuestionId($question_id);
                                    $question_choice->save();
                                    /*
                                    * get choice_id and format correct text to mach correct id from db, for updating question table for correct answer
                                    * */
                                    $new_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                                }
                                /*
                                * update question choice
                                * */
                                else{
                                    $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                                    $question_choice[$k-1]->setText($v['answer']);
                                    $question_choice->save();
                                    /*
                                    * get choice_id and format correct text to mach correct id from db, for updating question table for correct answer
                                    * */
                                    $new_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                                }


                            }
                        }

                        foreach($correct_text_array as $c=>$b){
                            $correct_choice_id_array[] = $new_choice[intval($b-1)]->getChoiceId();
                        }
                        $correct_text_choice_id = implode(',',$correct_choice_id_array);

                        $question_update_correct_text = PropQuestionQuery::create()->findOneByQuestionId($question_id);
                        $question_update_correct_text->setCorrectText($correct_text_choice_id);
                        $question_update_correct_text->save();
                    }
                }
                break;
        }


        /*
         * Update challenge question table
         * */
        $this->update_challenge_question_table($question_id,$challenge_id);

        return $question;

    }

    public function get_question_by_id($id){
        return PropQuestionQuery::create()->findOneByQuestionId($id);
    }
    public function get_choices_by_question_id($id){
        return PropQuestionChoiceQuery::create()->findByQuestionId($id);
    }

    public function get_question_image($question_id){
        $img = $this->db->select('image')
            ->where('question_id',$question_id)->get('questions')->result_array();

        return $img[0];
    }

    public function display_question_choice_image($choice_id){
        $img = $this->db->select('image')
            ->where('choice_id',$choice_id)->get('question_choices')->result_array();
        return $img[0];
    }

    public function get_challenge_by_id($id){
        return PropChallengeQuery::create()->findOneByChallengeId($id);
    }

    /*
     * Private function's
     * */
    private function update_challenge_question_table($question_id, $challenge_id){
        $challenge_question = new PropChallengeQuestion();
        $challenge_question->setQuestionId($question_id);
        $challenge_question->setChallengeId($challenge_id);
        $challenge_question->save();
    }

    public function delete($id){

        $question = PropQuestionQuery::create()->findOneByQuestionId(intval($id));
        $question->setIsDeleted(PropQuestionPeer::IS_DELETED_YES);
        $question->save();

        if ($question->getIsDeleted() === PropQuestionPeer::IS_DELETED_YES) {
            $out = array('deleted' => true);
        } else {
            $out = array('deleted' => false);
        }
        return $out;
    }
}