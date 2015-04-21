<?php
/**
 * Wrapper for Propel model of Grade table.
 */

class Grade_model extends CI_Model{

    protected $orderBy = null;
    protected $orderByDirection = null;
    protected $limit = null;
    protected $offset = null;
	protected $totalRows;

    public function __construct(){ parent:: __construct(); }

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;
        $this->totalRows = null;
    }

    private function prepareListQuery(){
        $query = PropGradeQuery::create();
        return $query;
    }

    public function getList(){
        $this->totalRows = $this->prepareListQuery()->count();

        $query = $this->prepareListQuery();
        if (! empty($this->orderBy)) {
            $query->orderBy($this->orderBy, $this->orderByDirection);
        }
        $query->limit($this->limit);
        $query->offset($this->offset);

        return $query->find();
    }

	public function getFoundRows() { return (int)$this->totalRows; }
    public function setOrderBy($field) { $this->orderBy = $field; }
    public function setOrderByDirection($direction) { $this->orderByDirection = $direction; }
    public function setLimit($limit) { $this->limit = $limit; }
    public function setOffset($offset) { $this->offset = $offset; }

        //***************************************************
        // SEARCH
        //***************************************************

    public function getGradeById($id) {
        return PropGradeQuery::create()->findOneById($id);
    }

	public function getGradeByName($gradeName) {
        $grade = PropGradeQuery::create()
            //->filterByName('%' . $gradeName . '%', Criteria::LIKE)
            ->filterByName($gradeName, Criteria::LIKE)
            ->findOne();
		return (empty($grade)) ? null : $grade;
	}
}