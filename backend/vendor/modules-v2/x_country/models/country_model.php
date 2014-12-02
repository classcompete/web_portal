<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 8/5/14
 * Time: 4:42 PM
 */
class Country_model extends CI_Model {

    private $orderBy            = null;
    private $orderByDirection   = null;
    private $limit              = null;
    private $offset             = null;
    private $totalRows          = null;

    private $filterStatus = null;

    public function __construct(){parent:: __construct();}

    public function resetFilters(){
        $this->orderBy          = null;
        $this->orderByDirection = null;
        $this->limit            = 10;
        $this->offset           = 0;
        $this->totalRows        = null;

        $this->filterStatus     = null;

    }
    public function getFoundRows(){
        return (int)$this->totalRows;
    }

    private function prepareListQuery(){
        $query = PropCountryQuery::create();

        if(isset($this->filterStatus)){
            $query->filterByStatus($this->filterStatus,Criteria::EQUAL);
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
        return PropCountryQuery::create()->findOneById($id);
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

    public function filterByStatus($status){
        $this->filterStatus = $status;
    }
}