<?php

class Teacher_import_model extends CI_Model{

	protected $orderBy = null;
    protected $orderByDirection = null;
    protected $limit = null;
    protected $offset = null;
    protected $totalRows;

    public function save($data, $id = null) {
        $import = PropTeacherImportQuery::create()->findOneById($id);
        if (empty($import)) {
            $import = new PropTeacherImport();
        }

        if (isset($data->name)) { $import->setName($data->name); }
	    if (isset($data->file)) { $import->setFile($data->file); }
        if (isset($data->status)) { $import->setStatus($data->status); }

        $import->save();
        return $import;
    }

    public function resetFilters() {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;
        $this->totalRows = null;
    }

    private function prepareListQuery() {
        $query = PropTeacherImportQuery::create();
        return $query;
    }

    public function getList() {
        $this->totalRows = $this->prepareListQuery()->count();
        $query = $this->prepareListQuery();

        if (empty($this->orderBy) === false) {
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

    public function findOneById($id) {
        return PropTeacherImportQuery::create()->findOneById($id);
    }

    public function deleteById($id) {
        return PropTeacherImportQuery::create()->filterById($id)->delete();
    }
}