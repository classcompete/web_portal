<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/17/13
 * Time: 11:51 AM
 * To change this template use File | Settings | File Templates.
 */
class Challenge_question_model extends CI_Model
{
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

    public function save_question_1_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false ) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }



        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }
        if(isset($data->two_answer) === true){
            if(count($data->two_answer) === 2){
                foreach($data->two_answer as $k=>$v){
                    if(isset($v['answer']) === true ){
                        /*
                        * insert new question choice if id is empty
                        * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                            $question_choice[$k-1]->setText($v['answer']);
                            $question_choice->save();

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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
    }
    public function save_question_2_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true ) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }

        if (isset($data->four_answer) === true) {
            if (count($data->four_answer) === 4) {
                foreach ($data->four_answer as $k => $v) {
                    if (isset($v['answer']) === true) {

                        /*
                         * insert new question choice if id is empty
                         * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                            $question_choice[$k-1]->setText($v['answer']);
                            $question_choice->save();

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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
    }
    public function save_question_3_type($data,$challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->image_thumb) === true && empty($data->image_thumb) === false) {
            $question->setImage($data->image_thumb);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }

        if (isset($data->four_answer) === true) {
            if (count($data->four_answer) === 4) {
                foreach ($data->four_answer as $k => $v) {
                    if (isset($v['answer']) === true ) {

                        /*
                         * insert new question choice if id is empty
                         * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                            $question_choice[$k-1]->setText($v['answer']);

                            if(isset($v['image']) === true && empty($v['image']) === false){
                                $question_choice[$k-1]->setImage($v['image']);
                            }
                            $question_choice->save();

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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
    }
    public function save_question_4_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true ) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }

        /*
         * HACK - Update question correct if image isn't provided
         * */

        if (isset($data->correct_answer) === true && empty($data->correct_answer) === false && empty($id) === false) {
            $this->update_correct_choice_hack($data, $question_id);
        }

        if (isset($data->four_image) === true && empty($data->four_image) === false) {
            if (count($data->four_image) === 4) {
                foreach ($data->four_image as $k => $v) {
                    if (isset($v['answer']) === true && empty($v['answer']) === false) {

                        /*
                         * insert new question choice if id is empty
                         * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);

                            if ($v['answer'] !== null){
                                $question_choice[$k-1]->setImage($v['answer']);
                                $question_choice->save();
                            }

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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

    }
    public function save_question_5_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->image_thumb) === true && empty($data->image_thumb) === false) {
            $question->setImage($data->image_thumb);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        /*
         * HACK - Update question correct if image isn't provided
         * */

        if (isset($data->correct_answer) === true && empty($data->correct_answer) === false && empty($id) === false) {
            $this->update_correct_choice_hack($data, $question_id);
        }


        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }
        if (isset($data->four_image) === true && empty($data->four_image) === false) {
            if (count($data->four_image) === 4) {
                foreach ($data->four_image as $k => $v) {
                    if (isset($v['answer']) === true && empty($v['answer']) === false) {

                        /*
                         * insert new question choice if id is empty
                         * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                            $question_choice[$k-1]->setImage($v['answer']);
                            $question_choice->save();

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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
    }
    public function save_question_6_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }

        /*
        * save data in questions table
        * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }

        if (isset($data->eight_answer) === true) {
            if (count($data->eight_answer) === 8) {
                foreach ($data->eight_answer as $k => $v) {
                    if (isset($v['answer']) === true) {

                        /*
                         * insert new question choice if id is empty
                         * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                            $question_choice[$k-1]->setText($v['answer']);
                            $question_choice->save();

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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

    }
    public function save_question_7_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true ) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->correct_text) === true) {
            $question->setCorrectText($data->correct_text);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }
    }
    public function save_question_8_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->correct_text) === true ) {
            $question->setCorrectText($data->correct_text);
        }
        if (isset($data->image_thumb) === true && empty($data->image_thumb) === false) {
            $question->setImage($data->image_thumb);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }
    }
    public function save_question_9_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question   = new PropQuestion();
        } else {
            $question   = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true ) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->image_thumb) === true && empty($data->image_thumb) === false) {
            $question->setImage($data->image_thumb);
        }

        /*
        * save data in questions table
        * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
        * Update challenge question table
        * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }

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

    }
    public function save_question_10_type($data,$challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->image_thumb) === true && empty($data->image_thumb) === false) {
            $question->setImage($data->image_thumb);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }

        if (isset($data->two_answer) === true) {
            if (count($data->two_answer) === 2) {
                foreach ($data->two_answer as $k => $v) {
                    if (isset($v['answer']) === true ) {

                        /*
                         * insert new question choice if id is empty
                         * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                            $question_choice[$k-1]->setText($v['answer']);

                            if(isset($v['image']) === true && empty($v['image']) === false){
                                $question_choice[$k-1]->setImage($v['image']);
                            }
                            $question_choice->save();

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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
    }
    public function save_question_11_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->image_thumb) === true && empty($data->image_thumb) === false) {
            $question->setImage($data->image_thumb);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        /*
         * HACK - Update question correct if image isn't provided
         * */

        if (isset($data->correct_answer) === true && empty($data->correct_answer) === false && empty($id) === false) {
            $this->update_correct_choice_hack($data, $question_id);
        }


        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }
        if (isset($data->two_image) === true && empty($data->two_image) === false) {
            if (count($data->two_image) === 2) {
                foreach ($data->two_image as $k => $v) {
                    if (isset($v['answer']) === true && empty($v['answer']) === false) {

                        /*
                         * insert new question choice if id is empty
                         * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                            $question_choice[$k-1]->setImage($v['answer']);
                            $question_choice->save();

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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
    }
    public function save_question_12_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true ) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }

        /*
         * HACK - Update question correct if image isn't provided
         * */

        if (isset($data->correct_answer) === true && empty($data->correct_answer) === false && empty($id) === false) {
            $this->update_correct_choice_hack($data, $question_id);
        }

        if (isset($data->two_image) === true && empty($data->two_image) === false) {
            if (count($data->two_image) === 2) {
                foreach ($data->two_image as $k => $v) {
                    if (isset($v['answer']) === true && empty($v['answer']) === false) {

                        /*
                         * insert new question choice if id is empty
                         * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);

                            if ($v['answer'] !== null){
                                $question_choice[$k-1]->setImage($v['answer']);
                                $question_choice->save();
                            }

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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

    }
    public function save_question_13_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false ) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }

        $question->setLargeSpace(PropQuestionPeer::LARGE_SPACE_YES);


        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }
        if(isset($data->two_answer) === true){
            if(count($data->two_answer) === 2){
                foreach($data->two_answer as $k=>$v){
                    if(isset($v['answer']) === true ){
                        /*
                        * insert new question choice if id is empty
                        * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                            $question_choice[$k-1]->setText($v['answer']);
                            $question_choice->save();

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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
    }
    public function save_question_14_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true ) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }

        $question->setLargeSpace(PropQuestionPeer::LARGE_SPACE_YES);

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }

        if (isset($data->four_answer) === true) {
            if (count($data->four_answer) === 4) {
                foreach ($data->four_answer as $k => $v) {
                    if (isset($v['answer']) === true) {

                        /*
                         * insert new question choice if id is empty
                         * */
                        if(empty($id) === true){
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
                            /*
                             * update question choices
                             * */
                        }else{
                            $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);
                            $question_choice[$k-1]->setText($v['answer']);
                            $question_choice->save();

                            /*
                             * get choice_id for updateing question table for correct answer
                             * */
                            if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                $question_choice_id = $question_choice[$k-1]->getChoiceId();
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
    }
    public function save_question_15_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question   = new PropQuestion();
        } else {
            $question   = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
        if (isset($data->subject_id) === true && empty($data->subject_id) === false) {
            $question->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true && empty($data->skill_id) === false) {
            $question->setSkillId($data->skill_id);
        }
        if (isset($data->level) === true && empty($data->level) === false) {
            $question->setLevel($data->level);
        }
        if (isset($data->type) === true && empty($data->type) === false) {
            $question->setType($data->type);
        }
        if (isset($data->text) === true ) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true && empty($data->topic_id) === false) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->image_thumb) === true && empty($data->image_thumb) === false) {
            $question->setImage($data->image_thumb);
        }

        /*
        * save data in questions table
        * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
        * Update challenge question table
        * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }

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

    }
    public function save_question_16_type($data, $challenge_id, $id){
        if (empty($id) === true) {
            $question = new PropQuestion();
        } else {
            $question = PropQuestionQuery::create()->findOneByQuestionId($id);
        }
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
        if (isset($data->text) === true ) {
            $question->setText($data->text);
        }
        if (isset($data->topic_id) === true) {
            $question->setTopicId($data->topic_id);
        }
        if (isset($data->correct_text) === true) {
            $question->setCorrectText($data->correct_text);
        }
        if (isset($data->read_text) === true) {
            $question->setReadText($data->read_text);
        }

        /*
         * save data in questions table
         * */
        $question->save();

        $question_id = $question->getQuestionId();

        /*
         * Update challenge question table
         * */

        if(empty($id) === true){
            $this->update_challenge_question_table($question_id,$challenge_id,'');
        }
    }

    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterSubjectName = null;
        $this->filterSkillName = null;
        $this->filterLevel = null;
        $this->filterChallengeId = null;

        $this->total_rows = null;
    }
    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }
    private function prepareListQuery(){
        $query = PropChallengeQuestionQuery::create()->filterByChallengeId($this->filterChallengeId, Criteria::LIKE);

        if (empty($this->filterSubjectName) === false) {
            $query->usePropQuestionQuery()
                ->usePropSubjectsQuery()->filterByName('%' . $this->filterSubjectName . '%', Criteria::LIKE)->endUse()
            ->endUse();
        }
        if (empty($this->filterSkillName) === false) {
            $query->usePropQuestionQuery()
                ->usePropSkillsQuery()->filterByName('%' . $this->filterSkillName . '%', Criteria::LIKE)->endUse()
            ->endUse();
        }
        if (empty($this->filterLevel) === false) {
            $query->usePropQuestionQuery()
                ->filterByLevel('%' . $this->filterLevel . '%', Criteria::LIKE)
            ->endUse();
        }

        return $query;
    }
    public function getList()
    {
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
     * Setter's
     * */
    public function set_order_by($field)
    {
        $this->orderBy = $field;
    }

    public function setChallenge_id($id){
        $this->filterChallengeId = $id;
    }

    public function filterByChallengeId($id){
        $this->filterChallengeId = $id;
    }

    public function set_order_by_direction($direction)
    {
        $this->orderByDirection = $direction;
    }

    public function set_limit($limit)
    {
        $this->limit = $limit;
    }

    public function set_offset($offset)
    {
        $this->offset = $offset;
    }
    /*
     * Getter's
     * */

    public function get_amount_number_of_questions($challenge_id){
        return PropChallengeQuestionQuery::create()->filterByChallengeId($challenge_id)->count();
    }
    public function get_challenge_data($challenge_id){
        return PropChallengeQuery::create()->findOneByChallengeId($challenge_id);
    }

    public function get_question_by_id($id)
    {
        return PropQuestionQuery::create()->findOneByQuestionId($id);
    }

    public function get_challenge_by_question_id($question_id)
    {
        return PropChallengeQuestionQuery::create()->findOneByQuestionId($question_id);
    }

    public function get_choices_by_question_id($id)
    {
        return PropQuestionChoiceQuery::create()->findByQuestionId($id);
    }

    public function get_choice_by_id($id)
    {
        return PropQuestionChoiceQuery::create()->findOneByChoiceId($id);
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

    /*
     * Filter's
     * */

    public function filterBySubjectName($string)
    {
        $this->filterSubjectName = $string;
    }

    public function filterBySkillName($string)
    {
        $this->filterSkillName = $string;
    }

    public function filterByLevel($string)
    {
        $this->filterLevel = $string;
    }

    public function delete($challenge_id, $question_id){
        $data = PropChallengeQuestionQuery::create()->filterByQuestionId($question_id)->filterByChallengeId($challenge_id);

        $data->delete();
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
    private function update_correct_choice_hack($data, $question_id){
        $question_choice = PropQuestionChoiceQuery::create()->findByQuestionId($question_id);

        foreach($question_choice as $choice=>$val){
            if( ($choice + 1 ) === $data->correct_answer){
                $correct_choice_id =  $val->getChoiceId();
            }
        }
        if (isset($correct_choice_id) === true && empty($correct_choice_id) === false) {
            $question_update = PropQuestionQuery::create()->findOneByQuestionId($question_id);
            $question_update->setCorrectChoiceId($correct_choice_id);
            $question_update->save();
        }

    }
}