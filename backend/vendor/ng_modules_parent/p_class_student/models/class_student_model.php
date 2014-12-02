<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/20/13
 * Time: 2:59 PM
 */
class Class_student_model extends CI_Model{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterStudentId = null;

    public function __construct(){parent::__construct();}

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterStudentId = null;
        $this->total_rows = null;
    }
    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropClass_studentQuery::create();

            $query->filterByIsDeleted(PropClass_studentPeer::IS_DELETED_NO);

        if (empty($this->filterStudentId) === false) {
            $query->filterByStudentId($this->filterStudentId, Criteria::EQUAL);
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

    public function filterByStudentId($string){
        $this->filterStudentId = $string;
    }

}