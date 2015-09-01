<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/17/13
 * Time: 11:51 AM
 * To change this template use File | Settings | File Templates.
 */
class Question_model extends CI_Model
{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterSubjectName = null;
    private $filterSkillName = null;
    private $filterLevel = null;


    public function __construct(){
        parent::__construct();
    }

    public function save($data, $id)
    {
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
        if (isset($data->image) === true && empty($data->image) === false) {
            $question->setImage($data->image);
        }
        if (isset($data->image_type) === true && empty($data->image_type) === false) {
            $question->setImageType($data->image_type);
        }
        if (isset($data->correct_text) === true && isset($data->order_slider) === false && empty($data->order_slider) === true) {
            $question->setCorrectText($data->correct_text);
        }
        /*
         * save data in questions table
         * */
        $question->save();


        /*
        * get id for question
        * */
        $question_id = $question->getQuestionId();
        if (isset($data->four_answer) === true && empty($data->four_answer) === false) {
            if (count($data->four_answer) === 4) {
                foreach ($data->four_answer as $k => $v) {
                    if (isset($v['answer']) === true && empty($v['answer']) === false) {

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
                             * get choice_id for updateing question table for correct answer
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
            } else if (isset($data->eight_answer) === true && empty($data->eight_answer) === false) {
                if (count($data->eight_answer) === 8) {
                    foreach ($data->eight_answer as $k => $v) {
                        if (isset($v['answer']) === true && empty($v['answer']) === false) {

                            /*
                            * insert new question choice if id is empty
                            * */

                            if(empty($id) === true){
                                $question_choice = new PropQuestionChoice();
                                $question_choice->setText($v['answer']);
                                $question_choice->setQuestionId($question_id);
                                if(isset($v['image']) === true && empty($v['image']) === false){
                                    $question_choice->setImage($v['image']);
                                }
                                $question_choice->save();

                                /*
                                 * get choice_id for updating question table for correct answer
                                 * */

                                if (isset($v['correct']) === true && empty($v['correct']) === false && $v['correct'] === 'true') {
                                    $question_choice_id = $question_choice->getChoiceId();
                                }
                            }

                            /*
                            * update question choices
                            * */
                            else{
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
            /*
             * set data to save for order_slider type
             * */
            else if(isset($data->order_slider) === true && empty($data->order_slider) === false){
                $correct_text_array =  explode(',',$data->correct_text);
                $correct_choice_id_array = array();
                foreach($data->order_slider as $k=>$v){
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

        return $question;
    }

    public function _delete($data){
        if(isset($data->question_id) === true && empty($data->question_id) === false){
            $question = PropQuestionQuery::create()->findOneByQuestionId($data->question_id);

            $question->setIsDeleted(PropQuestionPeer::IS_DELETED_YES);

            $question->save();

            return $question;


        }
    }

    public function delete($data){
        $question = PropQuestionQuery::create()->findOneByQuestionId($data->question_id);

        $question->delete();

        return $question;
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

        $this->total_rows = null;
    }

    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropQuestionQuery::create();

        if (empty($this->filterSubjectName) === false) {
            $query->usePropSubjectsQuery()->filterByName('%' . $this->filterSubjectName . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->filterSkillName) === false) {
            $query->usePropSkillsQuery()->filterByName('%' . $this->filterSkillName . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->filterLevel) === false) {
            $query->filterByLevel('%' . $this->filterLevel . '%', Criteria::LIKE);
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

    public function set_order_by($field)
    {
        $this->orderBy = $field;
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

    public function get_question_by_id($id)
    {
        return PropQuestionQuery::create()->findOneByQuestionId($id);
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
            ->where('choice_id',$choice_id)->get('questions')->result_array();
        return $img[0];
    }

    public function get_all_challenges(){
        return PropChallengeQuery::create()->find();
    }

    public function count_questions_in_challegne($challenge_id){
        return PropChallengeQuestionQuery::create()->filterByChallengeId($challenge_id)->count();
    }
    public function count_questions_in_challenge($challenge_id){
        return PropChallengeQuestionQuery::create()->filterByChallengeId($challenge_id)->count();
    }

	/**
	 * Get list of teacher's questions filtered by specified params
	 * @param $teacherUserId
	 * @param $excludeChallengeId
	 * @param $subjectId
	 * @param $topicId
	 * @param $grade
	 */
	public function getQuestionsByTeacher($teacherUserId, $excludeChallengeId, $subjectId = null, $topicId = null, $grade = null) {
        $questions = $this->db->select('question_id')
								->where('challenge_id', $excludeChallengeId)
								->get('challenge_questions')->result();
        $curr_questions_array = array();
        foreach($questions as $q){
            $curr_questions_array[] = $q->question_id;
        }

        $this->db->distinct()
			->select('q.*, su.name as subject_name, sk.name as topic_name')
			->from('questions q')
	        ->join('challenge_questions cq', 'q.question_id = cq.question_id')
	        ->join('challenges c', 'c.challenge_id = cq.challenge_id')
	        ->join('subjects su', 'q.subject_id = su.subject_id')
	        ->join('skills sk', 'q.skill_id = sk.skill_id')
	        ->where('c.user_id', $teacherUserId)
            //->where('cq.challenge_id <>', $excludeChallengeId)
	        ->order_by('q.level, subject_name');

		if (!empty($curr_questions_array)) {
			$this->db->where_not_in('q.question_id', $curr_questions_array);
		}

		if ($subjectId) {
			$this->db->where('q.subject_id', $subjectId);
		}

		if ($topicId) {
			$this->db->where('q.skill_id', $topicId);
		}

		if ($grade) {
			$this->db->where('q.level', $grade);
		}

        $query = $this->db->get()->result_array();
        return $query;
	}
}