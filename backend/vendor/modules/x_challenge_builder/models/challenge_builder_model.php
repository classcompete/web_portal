<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/19/13
 * Time: 1:08 PM
 * To change this template use File | Settings | File Templates.
 */
class Challenge_builder_model extends CI_Model{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;
    private $user_id = null;

    private $filterNameChallenge = null;
    private $filterNameSubject = null;
    private $filterNameSkill = null;
    private $filterLevel = null;
    private $filterNameGame = null;
    private $filterNameGameLevel = null;
    private $filterNameTopic = null;

    public function __construct(){
        parent::__construct();
    }

    public function install_challenge_to_class($data){
        $query = new PropChallengeClass();

        if(isset($data->class_id) === true && empty($data->class_id) === false){
            $query->setClassId($data->class_id);
        }
        if(isset($data->challenge_id) === true && empty($data->challenge_id) === false){
            $query->setChallengeId($data->challenge_id);
        }
        $query->save();

        return $query;
    }

    public function save_question($data, $challenge_id){

        /*
        * Part to save question
        * */

        $challenge_data = $this->get_challenge_by_id($challenge_id);


        $question = new PropQuestion();
        $question->setSubjectId($challenge_data->subject_id);
        $question->setSkillId($challenge_data->skill_id);
        $question->setLevel($challenge_data->level);
        $question->setType($challenge_data->type);
        $question->setText($challenge_data->text);
        $question->setTopicId($challenge_data->topic_id);

        if (isset($data->image_thumb) === true && empty($data->image_thumb) === false) {
            $question->setImage($data->image_thumb);
        }
        if (isset($data->correct_text) === true && empty($data->correct_text) === false) {
            $question->setCorrectText($data->correct_text);
        }
        $question->save();
        $question_id = $question->getQuestionId();

        switch($data->question_type){
            case 'question_type_1':
                if(isset($data->question_type_1) === true && empty($data->question_type_1) === false){
                    if(count($data->question_type_1) === 2){
                        foreach($data->question_type_1 as $k=>$v){
                            if(isset($v['answer']) === true && empty($v['answer']) === false){
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
                break;
            case 'question_type_8':
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
            case 'question_type_10':
                if (isset($data->question_type_10) === true && empty($data->question_type_10) === false) {
                    if (count($data->question_type_10) === 2) {
                        foreach ($data->question_type_10 as $k => $v) {
                            if (isset($v['answer']) === true && empty($v['answer']) === false) {

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
            case 'question_type_11':
                if (isset($data->question_type_11) === true && empty($data->question_type_11) === false) {
                    if (count($data->question_type_11) === 2) {
                        foreach ($data->question_type_11 as $k => $v) {
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
            case 'question_type_12':
                if (isset($data->question_type_12) === true && empty($data->question_type_12) === false) {
                    if (count($data->question_type_12) === 2) {
                        foreach ($data->question_type_12 as $k => $v) {
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
            case 'question_type_13':
                if(isset($data->question_type_13) === true && empty($data->question_type_13) === false){
                    if(count($data->question_type_13) === 2){
                        foreach($data->question_type_13 as $k=>$v){
                            if(isset($v['answer']) === true && empty($v['answer']) === false){
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
            case 'question_type_14':
                if (isset($data->question_type_14) === true && empty($data->question_type_14) === false) {
                    if (count($data->question_type_14) === 4) {
                        foreach ($data->question_type_14 as $k => $v) {
                            if (isset($v['answer']) === true && empty($v['answer']) === false) {

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
        }


        /*
         * Update challenge question table
         * */
        $this->update_challenge_question_table($question_id,$challenge_id,'');

        return $question;

    }

	/**
	 * Save only new challenge data - without question data
	 * @param $data
	 * @return PropChallenge
	 * @throws Exception
	 * @throws PropelException
	 */
    public function save_challenge($data){
        $ch = new PropChallenge();

        if (isset($data->name) === true && empty($data->name) === false) {
            $ch->setName($data->name);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $ch->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $ch->setSkillId($data->skill_id);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $ch->setTopicId($data->topic_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $ch->setLevel($data->level);
        }
        if (isset($data->game_id) === true && empty($data->game_id) === false) {
            $ch->setGameId($data->game_id);
        }
        if(isset($data->user_id) === true && empty($data->user_id) === false){
            $ch->setUserId($data->user_id);
        }
        if(isset($data->description) === true && empty($data->description) === false){
            $ch->setDescription($data->description);
        }
        if(isset($data->is_public) === true ){
                $ch->setIsPublic($data->is_public);
        }
	    $ch->save();
	    $challenge_id = $ch->getChallengeId();

	        //Add challenge to challenge classroom table
        if (isset($data->class_id) === true && empty($data->class_id) === false) {
            $challenge_class = new PropChallengeClass();
            $challenge_class->setChallengeId($challenge_id);
            $challenge_class->setClassId($data->class_id);
            $challenge_class->save();
        }
        return $ch;
    }

	/**
	 * Save new or existing challenge record - with question data
	 * @param $data
	 * @param $challenge_id
	 * @return PropChallenge
	 * @throws Exception
	 * @throws PropelException
	 */
    public function save($data,$challenge_id){
        if(empty($challenge_id) === true){
            $ch = new PropChallenge();
        }else{
            $ch = PropChallengeQuery::create()->findOneByChallengeId($challenge_id);
        }

        if (isset($data->name) === true) {
            $ch->setName($data->name);
        }
        if (isset($data->subject_id) === true) {
            $ch->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true) {
            $ch->setSkillId($data->skill_id);
        }
        if (isset($data->topic_id) === true) {
            $ch->setTopicId($data->topic_id);
        }
        if (isset($data->level) === true) {
            $ch->setLevel($data->level);
        }
        if (isset($data->game_id) === true) {
            $ch->setGameId($data->game_id);
        }
        if(isset($data->user_id) === true){
            $ch->setUserId($data->user_id);
        }
        if(isset($data->description) === true){
            $ch->setDescription($data->description);
        }
        if (isset($data->read_title) === true) {
            $ch->setReadTitle($data->read_title);
        }
        if (isset($data->read_image) === true) {
            $ch->setReadImage($data->read_image);
        }
        if (isset($data->read_text) === true) {
            $ch->setReadText($data->read_text);
        }

        if(isset($data->is_public) === true && $data->is_public === PropChallengePeer::IS_PUBLIC_YES){
            $ch->setIsPublic(PropChallengePeer::IS_PUBLIC_YES);
        } else {
            $ch->setIsPublic(PropChallengePeer::IS_PUBLIC_NO);
        }
        $ch->save();
        $challenge_id = $ch->getChallengeId();

        /*
         * Part to save question
         * */

        $question = new PropQuestion();
        if (isset($data->subject_id) === true) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->image_thumb) === true) {
            $question->setImage($data->image_thumb);
        }
        if (isset($data->correct_text) === true) {
            $question->setCorrectText($data->correct_text);
        }
        if (isset($data->read_text) === true) {
            $question->setReadText($data->read_text);
        }
        $question->save();
        $question_id = $question->getQuestionId();

        switch($data->question_type){
            case 'question_type_1':
                if(isset($data->question_type_1) === true && empty($data->question_type_1) === false){
                    if(count($data->question_type_1) === 2){
                        foreach($data->question_type_1 as $k=>$v){
                            if(isset($v['answer']) === true && empty($v['answer']) === false){
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
                break;
            case 'question_type_8':
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
            case 'question_type_10':
                if (isset($data->question_type_10) === true && empty($data->question_type_10) === false) {
                    if (count($data->question_type_10) === 2) {
                        foreach ($data->question_type_10 as $k => $v) {
                            if (isset($v['answer']) === true && empty($v['answer']) === false) {

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
            case 'question_type_11':
                if (isset($data->question_type_11) === true && empty($data->question_type_11) === false) {
                    if (count($data->question_type_11) === 2) {
                        foreach ($data->question_type_11 as $k => $v) {
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
            case 'question_type_12':
                if (isset($data->question_type_12) === true && empty($data->question_type_12) === false) {
                    if (count($data->question_type_12) === 2) {
                        foreach ($data->question_type_12 as $k => $v) {
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
            case 'question_type_13':
                if(isset($data->question_type_13) === true && empty($data->question_type_13) === false){
                    if(count($data->question_type_13) === 2){
                        foreach($data->question_type_13 as $k=>$v){
                            if(isset($v['answer']) === true && empty($v['answer']) === false){
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
            case 'question_type_14':
                if (isset($data->question_type_14) === true && empty($data->question_type_14) === false) {
                    if (count($data->question_type_14) === 4) {
                        foreach ($data->question_type_14 as $k => $v) {
                            if (isset($v['answer']) === true && empty($v['answer']) === false) {

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
            case 'question_type_15':
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
            case 'question_type_16':
                break;
        }


        /*
         * Update challenge question table
         * */
         $this->update_challenge_question_table($question_id,$challenge_id,'');

        /*
         * Add challenge to challenge classroom table
         * */
        if (isset($data->class_id) === true && empty($data->class_id) === false) {
            $challenge_class = new PropChallengeClass();
            $challenge_class->setChallengeId($challenge_id);

            $challenge_class->setClassId($data->class_id);


            $challenge_class->save();
        }

        return $ch;
    }

    public function resetFilters(){

        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterNameChallenge = null;
        $this->filterNameSubject = null;
        $this->filterNameSkill = null;
        $this->filterLevel = null;
        $this->filterNameGame = null;
        $this->filterNameGameLevel = null;
        $this->filterNameTopic = null;
        $this->total_rows = null;
        $this->user_id = null;
    }

    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropChallengeQuery::create()->filterByUserId($this->user_id);

        return $query;
    }

    public function getList(){
        $this->total_rows = $this->prepareListQuery()->count();

        $query = $this->prepareListQuery();
        if (empty($this->orderBy) === false) {
            $query->orderBy($this->orderBy, $this->orderByDirection);
        }
        $query->limit($this->limit);
        $query->offset($this->offset);

        return $query->find();
    }

    /*
     * Filter's
     * */
    public function filterByNameChallenge($string){
        $this->filterNameChallenge = $string;
    }
    public function filterByNameSubject($string){
        $this->filterNameSubject = $string;
    }
    public function filterByNameSkill($string){
        $this->filterNameSkill = $string;
    }
    public function filterByLevel($string){
        $this->filterLevel = $string;
    }
    public function filterByNameGame($string){
        $this->filterNameGame = $string;
    }
    public function filterByNameGameLevel($string){
        $this->filterNameGameLevel = $string;
    }
    public function filterByNameTopic($string){
        $this->filterNameTopic = $string;
    }
    /*
     * Setter's
     * */

    public function set_order_by($field){
        $this->orderBy = $field;
    }
    public function set_order_by_direction($direction){
        $this->orderByDirection = $direction;
    }
    public function set_limit($limit){
        $this->limit = $limit;
    }
    public function set_offset($offset){
        $this->offset = $offset;
    }
    public function set_userId($id){
        $this->user_id = $id;
    }
    /*
    * Getter's
    * */

    public function get_subject(){
        $q = PropSubjectsQuery::create()->find();
        return $q;
    }
    public function get_skill($subject_id){
        $q = PropSkillsQuery::create()->filterBySubjectId($subject_id)->find();
        return $q;
    }
    public function get_topic($skill_id){
        $q = PropTopicQuery::create()->filterBySkillId($skill_id)->find();
        return $q;
    }
    public function get_game(){
        $q = PropGamesQuery::create()->find();
        return $q;
    }
    public function get_game_level($game_id){
        $q = PropGameLevelsQuery::create()->filterByGameId($game_id)->find();
        return $q;
    }
    public function get_challenge_by_id($id){

        $q = $this->db->where('challenges.challenge_id',$id)
            ->get('challenges')->row();
        return $q;
    }
    public function getTotalChallengeByTeacherId(){

        $class = PropClasQuery::create()->findByTeacherId($this->teacherId);
        $data = PropChallengeClassQuery::create()
            ->filterByPropClas($class)
            ->count();
        return $data;
    }
    public function get_teacher_classes($teacher_id){
        return PropClasQuery::create()->filterByTeacherId($teacher_id, Criteria::LIKE)->find();
    }
    public function get_teacher_name($user_id){
        $user =  PropUserQuery::create()->findOneByUserId($user_id);

        return $user->getFirstName() . ' '. $user->getLastName();
    }

    /**
     * function for getting number of questions im challene
     * @params: challenge_id
     * @out:    number of qustions
     * */
    public function get_number_of_questions_in_challenge($challenge_id){
        return PropChallengeQuestionQuery::create()->filterByChallengeId($challenge_id)->count();
    }

    public function get_classes($challenge_id){

        $query = PropClasQuery::create()
            ->findByTeacherId(TeacherHelper::getId());


        return $query;
    }

    /*
     * Function for checking if challenge is install on some class
     * @params: class_id challenge_id
     * @return: false if is not installed otherwise true
     * */

    public function installed_on_class($class_id, $challenge_id){
        $query = PropChallengeClassQuery::create()
            ->filterByClassId($class_id, Criteria::EQUAL)
            ->filterByChallengeId($challenge_id, Criteria::EQUAL)
            ->usePropClasQuery()
            ->filterByTeacherId(TeacherHelper::getId())
            ->endUse()
            ->find();

        if($query->isEmpty()){
            return false;
        }else{
            return true;
        }
    }


    /*
    * Private function's
    * */
    private function update_challenge_question_table($question_id, $challenge_id, $seq_num){
        $challenge_question = new PropChallengeQuestion();
        $challenge_question->setQuestionId($question_id);
        $challenge_question->setChallengeId($challenge_id);
        $challenge_question->setSeqNum('ne znam');
        $challenge_question->save();
    }

    public function is_challenge_name_unique($name, $challenge_id = null)
    {
        // adding new challenge
        if (empty($challenge_id) === true) {
            $challenge = PropChallengeQuery::create()->findOneByName($name);

            if (empty($challenge) === true) {
                $unique = true;
            } else {
                $unique = false;
            }
        } else { // editing old challenge
            $challenge = PropChallengeQuery::create()->filterByName($name)->filterByChallengeId($challenge_id, Criteria::NOT_EQUAL)->findOne();

            if (empty($challenge) === true) {
                $unique = true;
            } else {
                $unique = false;
            }
        }

        return $unique;
    }
}
