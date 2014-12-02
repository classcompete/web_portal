<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/7/14
 * Time: 1:22 PM
 */
class Grade_model extends CI_Model{


    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;


    public function __construct(){parent:: __construct();}

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->total_rows = null;

    }
    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropGradeQuery::create();

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

    public function setOrderBy($field){
        $this->orderBy = $field;
    }

    public function setOrderByDirection($direction){
        $this->orderByDirection = $direction;
    }

    public function setLimit($limit){
        $this->limit = $limit;
    }

    public function setOffset($offset){
        $this->offset = $offset;
    }

    public function getGrade($gradeId){
        return PropGradeQuery::create()->findOneById($gradeId);
    }

}