<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/4/14
 * Time: 12:31 PM
 */
class Parent_student_model extends CI_Model{

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterParentId = null;

    public function __construct(){parent:: __construct();}

    public function save($data, $id = null){

        if(empty($id)){
            $query = new PropParentStudents();
        }else{
            $query = PropParentStudentsQuery::create()->findOneById($id);
        }

        if(empty($data->parentId) === false){
            $query->setParentId($data->parentId);
        }
        if(empty($data->studentId) === false){
            $query->setStudentId($data->studentId);
        }

        $query->save();

        return $query;
    }

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->total_rows = null;

        $this->filterByParentId = null;
    }
    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropParentStudentsQuery::create();

        if(empty($this->filterParentId) === false){
            $query->filterByParentId($this->filterParentId);
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

    public function filterByParentId($parentId){
        $this->filterParentId = $parentId;
    }

    public function getStudentsWithoutClass($classId){
        $this->db->distinct();
        $this->db->select('parent_students.student_id, users.first_name, users.last_name');
        $this->db->join('students','parent_students.student_id = students.student_id', 'INNER');
        $this->db->join('users','users.user_id = students.user_id', 'INNER');
        $this->db->join('class_students','class_students.student_id = students.student_id AND class_students.class_id != '.$classId, 'LEFT');
        $this->db->where('parent_students.parent_id',$this->filterParentId);
        $q = $this->db->get('parent_students')->result_array();

        return $q;
    }
}