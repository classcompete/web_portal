<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/11/13
 * Time: 7:09 PM
 * To change this template use File | Settings | File Templates.
 */
class Class_student_model extends CI_Model{

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterClassName = null;
    private $filterStudentFirstName = null;
    private $filterStudentLastName = null;
    private $filterStudentId = null;
    private $filterTeacherId = null;
    private $filterClassId = null;

    public function __construct(){
        parent::__construct();
    }

    public function save($data, $id){
        if(empty($id) === true){
            $classStudents = new PropClass_student();
        }else{
            $classStudents = PropClass_studentQuery::create()->findOneByClassstudId($id);
        }
        if (isset($data->class_id) === true && empty($data->class_id) === false) {
            $classStudents->setClassId($data->class_id);
        }
        if (isset($data->user_id) === true && empty($data->user_id) === false) {
            $student = PropStudentQuery::create()->findOneByUserId($data->user_id);
            $classStudents->setStudentId($student->getStudentId());
        }
        $classStudents->save();
        return $classStudents;
    }
    public function delete($class_id, $student_id){
        $class_student = PropClass_studentQuery::create()->filterByClassId($class_id)->filterByStudentId($student_id)->findOne();

//        $class_student->setIsDeleted(PropClass_studentPeer::IS_DELETED_YES);

        $class_student->delete();

        return $class_student;
    }
    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterClassName = null;
        $this->filterStudentFirstName = null;
        $this->filterStudentLastName = null;
        $this->filterStudentId = null;

        $this->filterTeacherId = null;
        $this->filterClassId = null;

        $this->total_rows = null;
    }

    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropClass_studentQuery::create();
        $query->joinPropClas();
        $query->joinPropStudent();
        $query->usePropStudentQuery()
                    ->joinPropUser()
            ->endUse();
        if(empty($this->filterTeacherId) === false){
            $query->usePropClasQuery()->filterByTeacherId($this->filterTeacherId)->endUse();

        }

        if(empty($this->filterClassName) === false){
            $query->usePropClasQuery()->filterByName('%' . $this->filterClassName . '%', Criteria::LIKE)->endUse();
        }

        if(empty($this->filterStudentId) === false){
            $query->filterByStudentId($this->filterStudentId);
        }
        if(empty($this->filterClassId) === false){
            $query->filterByClassId($this->filterClassId);
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

    public function getStudentId(){
        $q = PropClass_studentQuery::create()->find();

        $array = array();
        foreach($q as $r){
            $array = $r->getStudentId();
        }

        return $array;
    }

    public function set_order_by($field){
        $this->orderBy = $field;
    }

    public function set_order_by_direction($direction){
        $this->orderByDirection = $direction;
    }

    public function set_limit($limit){
        $this->limit = $limit;
    }

    public function set_offset($offset){
        $this->offset = $offset;
    }

    public function getStudentsExcludedFromClass($class_id){

        $existed_student = $this->db->select('student_id')
                                    ->where('class_id',intval($class_id))
                                    ->from('class_students')->get()->result();
        $student_array = array();
        foreach($existed_student as $ex_student){
            $student_array[] = intval($ex_student->student_id);
        }
        $this->db->select('student_id, users.first_name, users.last_name, users.user_id');
        $this->db->join('users','users.user_id = students.user_id');
        if(empty($student_array) === false){
            $this->db->where_not_in('student_id',$student_array);
        }
        $data = $this->db->get('students')->result();

        return $data;
    }
    public function getClass(){
        $this->load->model('x_class/class_model');
        $this->class_model->setTeacherId($this->filterTeacherId);
        return $this->class_model->getList();
    }

    public function filterByClassName($string){
        $this->filterClassName = $string;
    }
    public function filterByStudentFirstName($string){
        $this->filterStudentFirstName = $string;
    }
    public function filterByStudentLastName($string){
        $this->filterStudentLastName = $string;
    }
    public function filterByStudentId($string){
        $this->filterStudentId = $string;
    }
    public function filterByClassId($string){
        $this->filterClassId = $string;
    }

    /**
     * setters
     * */

    public function setTeacherId($id){
        $this->filterTeacherId = $id;
    }
    public function setClassId($id){
        $this->filterClassId = $id;
    }

    /**
     * Getter's
     * */

    public function getStudentCount(){

        $data = PropClass_studentQuery::create()
                ->count();
        return $data;
    }

    public function get_class_student_by_id($id){
        return PropClass_studentQuery::create()->findOneByClassstudId($id);
    }

    public function get_students()
    {
        return PropUserQuery::create()->usePropStudentQuery()->find();
    }

    public function getExcludedStudent($class_id){

        $students = PropUserQuery::create()
             ->usePropStudentQuery()
                ->usePropClass_studentQuery()
                    ->filterByClassId($class_id, Criteria::NOT_EQUAL)
                ->endUse()
            ->endUse()
            ->find();

        return $students;
    }

    public function get_students_in_class($class_id){
        return PropClass_studentQuery::create()->filterByIsDeleted(PropClass_studentPeer::IS_DELETED_NO)->findByClassId($class_id);
    }

    public function count_students_in_teacher_class($teacher_id){
        return PropClass_studentQuery::create()
                    ->usePropClasQuery()
                        ->filterByTeacherId($teacher_id)
                    ->endUse()
                    ->count();
    }
}