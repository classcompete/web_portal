<?php

class Subject_model extends CI_Model
{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterName = null;

    public function __construct(){parent::__construct();}

    public function save($data, $id){
        if (empty($id) === true) {
            $subject = new PropSubjects();
        } else {
            $subject = PropSubjectsQuery::create()->findOneBySubjectId($id);
        }
        if (isset($data->name) === true && empty($data->name) === false) {
            $subject->setName($data->name);
        }
        $subject->save();
        return $subject;
    }

    public function get_subject_by_id($id){
        return PropSubjectsQuery::create()->findOneBySubjectId($id);
    }

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterName = null;


        $this->total_rows = null;
    }

    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropSubjectsQuery::create();
        if (empty($this->filterName) === false) {
            $query->filterByName('%' . $this->filterName . '%', Criteria::LIKE);
        }

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

    public function filterByName($string)
    {
        $this->filterName = $string;
    }
}