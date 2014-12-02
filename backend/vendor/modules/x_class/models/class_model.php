<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/11/13
 * Time: 1:27 PM
 * To change this template use File | Settings | File Templates.
 */
class Class_model extends CI_Model{

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;
    private $joinTable = null;
    private $filterName = null;
    private $filterAuthCode = null;
    private $filterTeacherId = null;
    private $filterTeacherLogin = null;

    public function __construct(){
        parent::__construct();
    }

    public function save($data , $id = null){
        if(empty($id) === true){
            $class = new PropClas();
        }else{
            $class = PropClasQuery::create()->findOneByClassId($id);

        }
        if (isset($data->name) === true && empty($data->name) === false) {
            $class->setName($data->name);
        }
        if (isset($data->auth_code) === true && empty($data->auth_code) === false) {
            $class->setAuthCode($data->auth_code);
        }if (isset($data->user_id) === true && empty($data->user_id) === false) {
            $teacher = PropTeacherQuery::create()->findOneByUserId($data->user_id);
            $class->setPropTeacher($teacher);
        }
        if(isset($data->price) === true){
            $class->setPrice($data->price);
        }
        if(isset($data->limit) === true){
            $class->setLimit($data->limit);
        }
        $class->save();

       return $class;
    }

    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $filterName = null;
        $filterAuthCode = null;
        $filterTeacherId = null;
        $joinTable = null;
        $filterTeacherLogin = null;
        $filterTeacherId = null;

        $this->total_rows = null;
    }

    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropClasQuery::create();

        if (empty($this->filterName) === false) {
            $query->filterByName('%' . $this->filterName . '%', Criteria::LIKE);
        }
        if (empty($this->filterAuthCode) === false) {
            $query->filterByAuthCode('%' . $this->filterAuthCode . '%', Criteria::LIKE);
        }
        if (empty($this->filterTeacherId) === false) {
            $query->filterByTeacherId($this->filterTeacherId);
        }
        if (empty($this->filterTeacherLogin) === false) {
            $query->filterByTeacherLogin($this->filterTeacherLogin);
        }
        return $query;
    }
    /*
     * Function's
     * */

    public function delete_class($class_id){
        $asc_data = PropClass_studentQuery::create()->filterByClassId($class_id)->count();

        if(intval($asc_data) === 0 ){
            $class = new PropClas();
            $class->setClassId($class_id);
            $class->delete();

            return $class;
        }else
            throw new Exception('Class can not be deleted, some students are registered to this class');

    }
    public function check_class_code($code){
        $status = PropClasQuery::create()->findOneByAuthCode($code);
        if($status === null){
            return false;
        }else{
            return true;
        }
    }

    public function check_edit_class_code($code, $class_id){
        $status = PropClasQuery::create()->findOneByAuthCode($code);

        if($status === null) return false;
        else if($status->getId() === intval($class_id)) return false;
        else return true;
    }


    public function filterByName($string){
        $this->filterName = $string;
    }
    public function filterByAuthCode($string){
        $this->filterAuthCode = $string;
    }
    public function filterByTeacherId($string){
        $this->filterTeacherId = $string;
    }
    public function filterByTeacherLogin($string){
        $this->filterTeacherLogin = $string;
    }
    public function filterByTeacherUserId($user_id){
        $teacher_id = PropTeacherQuery::create()->findOneByUserId($user_id);
        $this->filterTeacherId = $teacher_id->getTeacherId();
    }

    /*
     * setters
     * */
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
    public function setTeacherId($id){
        $this->filterTeacherId = $id;
    }

    public function setJoinTable($table)
    {
        $this->joinTable = $table;
    }

    /*
     * Getter's
     * */

    public function getTotalClassesByTeacherId(){
        return PropClasQuery::create()->filterByTeacherId($this->filterTeacherId)->count();
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

    public function get_class_by_id($id){
        return PropClasQuery::create()->findOneByClassId($id);
    }

    public function get_teachers(){
        $q = PropUserQuery::create()
            ->usePropTeacherQuery()
            ->endUse()
            ->find();
        return $q;
    }
    public function get_teacher_user_id_by_teacher_id($id){
        return PropTeacherQuery::create()->findOneByTeacherId($id);
    }
    public function get_students_count_from_class($class_id){
        return PropStudentQuery::create()
                    ->usePropClass_studentQuery()
                        ->filterByClassId($class_id)
                    ->endUse()
            ->count();
    }
    public function get_students_from_class($class_id){

        $students = PropUserQuery::create()
                    ->usePropStudentQuery()
                          ->usePropClass_studentQuery()
                                ->filterByClassId($class_id)
                                ->filterByIsDeleted(PropClass_studentPeer::IS_DELETED_NO)
                          ->endUse()
                    ->endUse();

        return $students->find();
    }
    public function get_student_profile($user_id){
        $student = PropStudentQuery::create()
                        ->filterByUserId($user_id)
                    ->joinWith('PropStudent.PropUser')->findOne();
        return $student;
    }
    public function get_student_image($user_id){
        $img = $this->db->select('avatar_thumbnail')
                        ->where('user_id',$user_id)->get('students')->result_array();
        return $img[0];
    }
}