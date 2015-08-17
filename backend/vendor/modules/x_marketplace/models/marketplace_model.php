<?php

/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/22/13
 * Time: 1:45 PM
 * To change this template use File | Settings | File Templates.
 */
class Marketplace_model extends CI_Model
{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;
    private $groupBy = null;
    private $filterSubjectId = null;
    private $filterLevel = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function save($data)
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

        $this->groupBy = null;
        $this->filterLevel = null;
        $this->filterSubjectId = null;

        $this->total_rows = null;
    }

    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropChallengeQuery::create();

        $query->filterByIsPublic(PropChallengePeer::IS_PUBLIC_YES);

        if (isset($this->filterLevel) === true && empty($this->filterLevel) === false) {
            $query->filterByLevel($this->filterLevel, Criteria::EQUAL);
        }
        if (isset($this->filterSubjectId) === true && empty($this->filterSubjectId) === false) {
            $query->filterBySubjectId($this->filterSubjectId);
        }

        return $query->setDistinct();
    }

    public function getList()
    {
        $this->total_rows = $this->prepareListQuery()->count();

        $query = $this->prepareListQuery();
        if (empty($this->orderBy) === false) {
            $query->orderBy($this->orderBy, $this->orderByDirection);
        }
        if (empty($this->groupBy) === false) {
            $query->groupBy($this->groupBy);
        }
        $query->limit($this->limit);
        $query->offset($this->offset);

        return $query->find();
    }

    /*
     * Setter's
     * */

    public function set_filter_by_level($string)
    {
        $this->filterLevel = $string;
    }

    public function set_group_by($field)
    {
        $this->groupBy = $field;
    }

    public function filterBySubjectId($id)
    {
        $this->filterSubjectId = $id;
    }

    public function filterByLevel($id)
    {
        $this->filterLevel = $id;
    }

    /*
     * Function's
     * */
    public function check_challenge($challenge_id)
    {
        $query = PropChallengeClassQuery::create()
            ->usePropClasQuery()
            ->filterByTeacherId(TeacherHelper::getId())
            ->endUse()
            ->find();

        foreach ($query as $k => $v) {
            if ($v->getPropChallenge()->getChallengeId() === $challenge_id) {
                return true;
            }
        }
    }

    /*
     * Getter's
     * */

    public function get_subject()
    {
        return PropSubjectsQuery::create()
            //urgent hack - to disable to subjects
            ->filterBySubjectId(array(5, 6), Criteria::NOT_IN)
            ->find();
    }

    public function get_classes($challenge_id)
    {
        $query = PropClasQuery::create()
            ->findByTeacherId(TeacherHelper::getId());

        return $query;
    }

    public function get_skill()
    {
        return PropSkillsQuery::create()
            //urgent hack - to topics for disabled subjects
            ->filterBySubjectId(array(5, 6), Criteria::NOT_IN)
            ->find();
    }

    /*
     * Function for checking if challenge is install on some class
     * @params: class_id challenge_id
     * @return: false if is not installed otherwise true
     * */

    public function installed_on_class($class_id, $challenge_id)
    {
        $query = PropChallengeClassQuery::create()
            ->filterByClassId($class_id, Criteria::EQUAL)
            ->filterByChallengeId($challenge_id, Criteria::EQUAL)
            ->usePropClasQuery()
            ->filterByTeacherId(TeacherHelper::getId())
            ->endUse()
            ->find();

        if ($query->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }
}