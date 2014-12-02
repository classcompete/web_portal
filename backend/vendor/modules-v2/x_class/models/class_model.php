<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 6/16/14
 * Time: 1:08 PM
 */
class Class_model extends CI_Model {

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;
    private $totalRows = null;
    private $excludeFreeClasses = null;

    public function __construct(){parent:: __construct();}

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;
        $this->totalRows = null;

        $this->excludeFreeClass = null;

    }
    public function getFoundRows(){
        return (int)$this->totalRows;
    }

    private function prepareListQuery(){
        $query = PropClasQuery::create();

        if(isset($this->excludeFreeClasses)){
            $query->filterByPrice(0,Criteria::NOT_EQUAL);
        }

        return $query;
    }

    public function getList(){
        $this->totalRows = $this->prepareListQuery()->count();

        $query = $this->prepareListQuery();
        if (empty($this->orderBy) === false) {
            $query->orderBy($this->orderBy, $this->orderByDirection);
        }
        $query->limit($this->limit);
        $query->offset($this->offset);

        return $query->find();
    }

    public function getById($id){
        return PropClasQuery::create()->findOneByClassId($id);
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

    public function filterByExcludeFreeClasses($free){
        $this->excludeFreeClasses = $free;
    }
}