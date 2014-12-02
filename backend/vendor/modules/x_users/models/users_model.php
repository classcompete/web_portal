<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/5/13
 * Time: 11:24 AM
 * To change this template use File | Settings | File Templates.
 */
class Users_model extends CI_model
{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterUsername = null;
    private $filterEmail = null;
    private $filterFirstName = null;
    private $filterLastName = null;
    private $filterClassId = null;
    private $excludeId = null;
    private $joinTable = null;


    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id){

        if (empty($id) === true) {
            $user = new PropUser();
        } else {
            $user = PropUserQuery::create()->findOneByUserId(intval($id));
            $user->setModified(date("Y-m-d H:i:s"));
        }
        if (isset($data->username) === true && empty($data->username) === false) {
            $user->setLogin($data->username);
        }
        if (isset($data->email) === true && empty($data->email) === false) {
            $user->setEmail($data->email);
        }
        if (isset($data->password) === true && empty($data->password) === false) {
            $user->setPassword($data->password);
        }
        if (isset($data->first_name) === true && empty($data->first_name) === false) {
            $user->setFirstName($data->first_name);
        }
        if (isset($data->last_name) === true && empty($data->last_name) === false) {
            $user->setLastName($data->last_name);
        }

        $user->save();

        if (empty($id) === true) {
                    $student = new PropStudent();
                    if(isset($data->image_thumb) === true && empty($data->image_thumb) === false){
                        $student->setImageThumb($data->image_thumb);
                    }
                    if(isset($data->dob) === true && empty($data->dob) === false){
                        $student->setDob($data->dob);
                    }
                    if(isset($data->parent_email) === true && empty($data->parent_email) === false){
                        $student->setParentEmail($data->parent_email);
                    }

                    $student->setPropUser($user);
                    $student->save();
        }else{
                    $student = PropStudentQuery::create()->findOneByUserId(intval($id));
                    if(isset($data->image_thumb) === true && empty($data->image_thumb) === false){
                        $student->setAvatarThumbnail($data->image_thumb);
                    }
                    if(isset($data->dob) === true && empty($data->dob) === false){
                        $student->setDob($data->dob);
                    }
                    if(isset($data->parent_email) === true && empty($data->parent_email) === false){
                        $student->setParentEmail($data->parent_email);
                    }
                    if(isset($student) === true && empty($student) === false){
                        $student->setModified(date("Y-m-d H:i:s"));
                        $student->setPropUser($user);
                        $student->save();
                    }
            }
        return $user;
    }

    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterUsername = null;
        $this->filterEmail = null;
        $this->filterLastName = null;
        $this->filterFirstName = null;
        $this->filterClassId = null;
        $this->joinTable = null;
        $this->excludeId = null;

        $this->total_rows = null;
    }

    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropUserQuery::create();
        $query->joinPropStudent();

        if (empty($this->filterUsername) === false) {
            $query->filterByLogin('%' . $this->filterUsername . '%', Criteria::LIKE);
        }
        if (empty($this->filterEmail) === false) {
            $query->filterByEmail('%' . $this->filterEmail . '%', Criteria::LIKE);
        }
        if (empty($this->filterFirstName) === false) {
            $query->filterByFirstName('%' . $this->filterFirstName . '%', Criteria::LIKE);
        }
        if (empty($this->filterLastName) === false) {
            $query->filterByLastName('%' . $this->filterLastName . '%', Criteria::LIKE);
        }
        if (empty($this->excludeId) === false) {

            $query->usePropStudentQuery()->filterByStudentId($this->excludeId, Criteria::NOT_EQUAL)->endUse();
        }

        if (empty($this->filterClassId) === false) {
            $subq = $query->usePropStudentQuery();
            $subq->usePropClass_studentQuery()
            ->filterByClassId($this->filterClassId)
            ->filterByIsDeleted(PropClass_studentPeer::IS_DELETED_NO)
            ->endUse();
            $subq->endUse();

        }

        return $query;
    }

    public function getList()
    {
        $this->total_rows = $this->prepareListQuery()->count();

        $query = $this->prepareListQuery();

        if (empty($this->orderBy) === false) {
                $query->orderBy($this->orderBy, $this->orderByDirection);
        }
        $query->limit($this->limit);
        $query->offset($this->offset);
        return $query->find();
    }

    public function change_password($user_id, $password){
        $sql = "UPDATE users SET users.password = PASSWORD('" . $password . "')
                WHERE users.user_id = '" . $user_id . "'";

        $this->db->query($sql);
    }

    public function is_unique_username_and_email($username, $email, $excludeId = null)
    {
        $userCount = PropUserQuery::create()
            ->filterByUserId($excludeId, Criteria::NOT_EQUAL)
            ->condition('username', PropUserPeer::LOGIN . ' = ?', $username)
            ->condition('email', PropUserPeer::EMAIL . ' = ?', $email)
            ->combine(array('username', 'email'), Criteria::LOGICAL_OR)
            ->count();
        $isUnique = empty($userCount);
        return $isUnique;
    }

    public function set_order_by($field)
    {
        $this->orderBy = $field;
    }

    public function set_order_by_direction($direction)
    {
        $this->orderByDirection = $direction;
    }

    public function set_limit($limit)
    {
        $this->limit = $limit;
    }

    public function set_offset($offset)
    {
        $this->offset = $offset;
    }

    public function filterByLogin($string)
    {
        $this->filterUsername = $string;
    }

    public function filterByEmail($string)
    {
        $this->filterEmail = $string;
    }

    public function filterByFirstName($string)
    {
        $this->filterFirstName = $string;
    }

    public function filterByLastName($string)
    {
        $this->filterLastName = $string;
    }

    public function filterByClassId($id)
    {
        $this->filterClassId = intval($id);
    }

    public function setJoinTable($table)
    {
        $this->joinTable = $table;
    }
    public function setExcludeId($id){
        $this->excludeId = $id;
    }

    /*
     * getter's
     * */
    public function getStudentCount(){
        return PropStudentQuery::create()->count();
    }
    public function get_user_by_id($id)
    {
        return PropUserQuery::create()->findOneByUserId($id);
    }

    public function get_user_type_by_id($id)
    {
        $student = PropStudentQuery::create()->findOneByUserId(intval($id));
        if ($student === null) {
            $teacher = PropTeacherQuery::create()->findOneByUserId(intval($id));
        }
        if ($student != null) {
            return 'student';
        } else if ($teacher != null) {
            return 'teacher';
        } else {
            return null;
        }
    }

    public function get_student_by_student_id($id)
    {
        return PropStudentQuery::create()->findOneByStudentId($id);
    }
    public function get_student_image($user_id){
        $img = $this->db->select('avatar_thumbnail')
            ->where('user_id',$user_id)->get('students')->result_array();
        return $img[0];
    }

    public function get_student_name($student_id){
        $student = PropStudentQuery::create()->findOneByStudentId($student_id);

        $user = PropUserQuery::create()->findOneByUserId($student->getUserId());

        return $user->getFirstName() . ' ' .$user->getLastName();
    }

    public function get_student_id_by_user_id($user_id){
        $student = PropStudentQuery::create()->findOneByUserId($user_id);
        return $student->getStudentId();
    }

}