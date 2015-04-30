<?php
/**
 * Wrapper for Propel model of Student_import table.
 * - Logs importing of student lists from external spreadsheet file
 */

class Student_import_model extends CI_Model{

	protected $orderBy = null;
    protected $orderByDirection = null;
    protected $limit = null;
    protected $offset = null;
    protected $totalRows;

    public function save($data, $id = null) {
        if (empty($id)) { $import = new PropStudentImport(); }
        else { $import = PropStudentImportQuery::create()->findOneById($id); }

	    if (isset($data->teacher_id)) { $import->setTeacherId($data->teacher_id); }
	    if (isset($data->class_id)) { $import->setClassId($data->class_id); }
        if (isset($data->name)) { $import->setName($data->name); }
	    if (isset($data->file_ext)) { $import->setFileExt($data->file_ext); }
	    if (isset($data->file)) { $import->setFile($data->file); }
        if (isset($data->status)) { $import->setStatus($data->status); }
	    if (isset($data->result_log)) { $import->setResultLog($data->result_log); }

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
        $query = PropStudentImportQuery::create()
			->joinPropClas()
			->withColumn('PropClas.Name', 'ClassName');
        return $query;
    }

    public function getList() {
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

    public function findOneById($id) {
        return PropStudentImportQuery::create()->findOneById($id);
    }

    public function deleteById($id) {
        return PropStudentImportQuery::create()->filterById($id)->delete();
    }
}