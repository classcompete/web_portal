<?php

class Skill_model extends CI_Model
{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterSubjectId = null;

    private $filterName = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id){
        if(empty($id) === true){
            $skill = new PropSkills();
        }else{
            $skill = BasePropSkillsQuery::create()->findOneBySkillId($id);
        }
        if(isset($data->name) === true && empty($data->name) === false){
            $skill->setName($data->name);
        }
        if(isset($data->subject_id) === true && empty($data->subject_id) === false){
            $skill->setSubjectId($data->subject_id);
        }
        $skill->save();
        return $skill;
    }

    public function get_skill_by_id($id)
    {
        return BasePropSkillsQuery::create()->findOneBySkillId($id);
    }
    public function get_skill_by_subject_id($id){
        return PropSkillsQuery::create()->filterBySubjectId($id)->find();
    }

    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterName = null;
        $this->filterSubjectId = null;

        $this->total_rows = null;
    }

    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropSkillsQuery::create();
        if (empty($this->filterName) === false) {
            $query->filterByName('%' . $this->filterName . '%', Criteria::LIKE);
        }
        if(empty($this->filterSubjectId) === false){
            $query->filterBySubjectId($this->filterSubjectId);
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


    public function filterByName($string)
    {
        $this->filterName = $string;
    }

    public function filterBySubjectId($string){
        $this->filterSubjectId = $string;
    }



    /*
     * Function's
     * */

    public function delete($skill_id){
        $topic = PropTopicQuery::create()->filterBySkillId($skill_id)->count();
        $challenge = PropChallengeQuery::create()->filterBySkillId($skill_id)->count();

        if(intval($topic) != 0){
            throw new Exception('Skill can not be deleted, some topic is connected to this skill');
        }
        if(intval($challenge) != 0){
            throw new Exception('Skill can not be deleted, some challenge is connected to this skill');
        }

        if(intval($topic) === 0 && intval($challenge) === 0){
            $skill = new PropSkills();
            $skill->setSkillId($skill_id);
            $skill->delete();
            return $skill;
        }
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

    /*
     * Getter's
     * */
}