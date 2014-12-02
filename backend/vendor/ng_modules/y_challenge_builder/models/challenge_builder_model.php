<?php
class Challenge_builder_model extends CI_Model
{
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

    public function __construct()
    {
        parent::__construct();
    }

    public function install_challenge_to_class($data)
    {
        $query = new PropChallengeClass();

        if (isset($data->class_id) === true && empty($data->class_id) === false) {
            $query->setClassId($data->class_id);
        }
        if (isset($data->challenge_id) === true && empty($data->challenge_id) === false) {
            $query->setChallengeId($data->challenge_id);
        }
        $query->save();

        return $query;
    }

    public function resetFilters()
    {

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

    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropChallengeQuery::create()->filterByUserId($this->user_id);

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

    public function getSingle($id)
    {
        return PropChallengeQuery::create()->findOneByChallengeId($id);
    }

    /*
     * Filter's
     * */
    public function filterByNameChallenge($string)
    {
        $this->filterNameChallenge = $string;
    }

    public function filterByNameSubject($string)
    {
        $this->filterNameSubject = $string;
    }

    public function filterByNameSkill($string)
    {
        $this->filterNameSkill = $string;
    }

    public function filterByLevel($string)
    {
        $this->filterLevel = $string;
    }

    public function filterByNameGame($string)
    {
        $this->filterNameGame = $string;
    }

    public function filterByNameGameLevel($string)
    {
        $this->filterNameGameLevel = $string;
    }

    public function filterByNameTopic($string)
    {
        $this->filterNameTopic = $string;
    }

    /*
     * Setter's
     * */

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

    public function set_userId($id)
    {
        $this->user_id = $id;
    }

    /*
    * Getter's
    * */

    public function get_teacher_name($user_id)
    {
        $user = PropUserQuery::create()->findOneByUserId($user_id);

        return $user->getFirstName() . ' ' . $user->getLastName();
    }

    /**
     * function for getting number of questions im challene
     * @params: challenge_id
     * @out:    number of questions
     * */
    public function get_number_of_questions_in_challenge($challenge_id)
    {
        return PropChallengeQuestionQuery::create()->filterByChallengeId($challenge_id)->count();
    }

}
