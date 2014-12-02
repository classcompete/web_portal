<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/23/13
 * Time: 3:17 PM
 * To change this template use File | Settings | File Templates.
 */
class Teacher_model extends CI_model
{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterUsername = null;
    private $filterEmail = null;
    private $filterFirstName = null;
    private $filterLastName = null;
    private $excludeId = null;
    private $joinTable = null;


    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id)
    {
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

        /** add new school if we have data */
        if(isset($data->zip_code) === true && empty($data->zip_code) === false && isset($data->school_name) === true && empty($data->school_name) === false){
            $new_school = new PropSchool();

            $new_school->setName($data->school_name);
            $new_school->setZipCode($data->zip_code);
            $new_school->setApproved(PropSchoolPeer::APPROVED_NOT_APPROVED);

            $new_school->save();
            $data->school_id = $new_school->getSchoolId();
        }

        if (empty($id) === true) {
            $teacher = new PropTeacher();
            $teacher->setPropUser($user);
            if (isset($data->avatar) === true && empty($data->avatar) === false){
                $teacher->setImageThumb($data->avatar);
            }
            if(isset($data->school_id) === true && empty($data->school_id) === false){
                $teacher->setSchoolId($data->school_id);
            }
            if(isset($data->biography) === true && empty($data->biography) === false){
                $teacher->setBiography($data->biography);
            }
            if(isset($data->publisher) === true && empty($data->publisher) === false){
                $teacher->setPublisher($data->publisher);
            }
            if (isset($data->country) === true) {
                $teacher->setCountry($data->country);
            }
            $teacher->save();

            if(isset($data->grades) === true && empty($data->grades) === false){
                foreach($data->grades as $grade=>$val){
                    $grade = new PropTeacherGrade();
                    $grade->setTeacherId($teacher->getTeacherId());
                    $grade->setGrade($val);
                    $grade->save();
                }
            }

        }else{

            $teacher = PropTeacherQuery::create()->findOneByUserId(intval($id));
            $teacher->setPropUser($user);
            $teacher->setModified(date("Y-m-d H:i:s"));

            if (isset($data->avatar) === true && empty($data->avatar) === false){
                $teacher->setImageThumb($data->avatar);
            }
            if(isset($data->biography) === true && empty($data->biography) === false){
                $teacher->setBiography($data->biography);
            }
            if(isset($data->school_id) === true && empty($data->school_id) === false){
                $teacher->setSchoolId($data->school_id);
            }
            if(isset($data->time_diff) === true && empty($data->time_diff) === false){
                $teacher->setTimeDiff($data->time_diff);
            }
            if(isset($data->publisher) === true && empty($data->publisher) === false){
                $teacher->setPublisher($data->publisher);
            }
            if (isset($data->country) === true) {
                $teacher->setCountry($data->country);
            }
            $teacher->save();

            $teacher_grades = PropTeacherGradeQuery::create()->findByTeacherId($teacher->getTeacherId());

            foreach($teacher_grades as $grade=>$val){
                $grade = PropTeacherGradeQuery::create()->findOneByTeacherGradeId($val->getTeacherGradeId());
                $grade->delete();
            }

            if(isset($data->grades) === true && empty($data->grades) === false){
                foreach($data->grades as $grade=>$val){
                    $grade = new PropTeacherGrade();
                    $grade->setTeacherId($teacher->getTeacherId());
                    $grade->setGrade($val);
                    $grade->save();
                }
            }
        }
        return $user;
    }


    public function change_school($data){

        $school = new PropSchool();
        $teacher = PropTeacherQuery::create()->findOneByTeacherId(TeacherHelper::getId());

        if(isset($data->school_id) === true && empty($data->school_id) === false){

            $teacher->setSchoolId($data->school_id);

            $teacher->save();

        }else{
            if(isset($data->zip_code) === true && empty($data->zip_code) == false && isset($data->school_name) === true && empty($data->school_name)=== false){

                $school->setZipCode($data->zip_code);
                $school->setName($data->school_name);
                $school->setApproved(PropSchoolPeer::APPROVED_NOT_APPROVED);

                $school->save();

                $teacher->setSchoolId($school->getSchoolId());
                $teacher->save();
            }
        }

        return $teacher;
    }

    public function delete($user_id){
        $teacher_id = PropTeacherQuery::create()->findOneByUserId($user_id);
        if(empty($teacher_id) === false){
            $count_class = PropClasQuery::create()->findByTeacherId($teacher_id->getTeacherId())->count();

            if(intval($count_class) === 0){
                $user_teacher = new PropUser();
                $user_teacher->setUserId($user_id);
                $user_teacher->delete();
                return $user_teacher;
            }else{
                throw new Exception('Teacher can not be deleted, some class are registered to this teacher');
            }
        }
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
        $query->joinPropTeacher();

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

    /*
     * Function's
     * */
    public function get_associated_data($id){
        /*
         * get teacher id
         * */

        $teacher_id = PropTeacherQuery::create()->findOneByUserId($id);

        if(empty($teacher_id) === false){
            $count_class = PropClasQuery::create()->findByTeacherId($teacher_id->getTeacherId())->count();

        }else{
            $count_class = null;
        }

        return $count_class;
    }

    public function is_unique_username_and_email($username, $email, $excludeId = null){
        $userCount = PropUserQuery::create()
            ->filterByUserId($excludeId, Criteria::NOT_EQUAL)
            ->condition('username', PropUserPeer::LOGIN . ' = ?', $username)
            ->condition('email', PropUserPeer::EMAIL . ' = ?', $email)
            ->combine(array('username', 'email'), Criteria::LOGICAL_OR)
            ->count();
        $isUnique = empty($userCount);
        return $isUnique;
    }

    public function get_teacher_image($user_id){
        $img = $this->db->select('image_thumb')
            ->where('user_id',$user_id)->get('teachers')->result_array();
        if (count($img) > 0) {
            $imageBaseCode = $img[0];
        } else {
            $imageBaseCode = null;
        }
        return $imageBaseCode;
    }

    public function get_teacher_info($id){
        return PropTeacherQuery::create()->findOneByUserId($id);
    }

    public function check_data_for_registration($data){
        $out = new stdClass();

        $username = PropUserQuery::create()->filterByLogin($data['username'], Criteria::EQUAL)->findOne();
        if(isset($username) === false && empty($username) === true){
            $out->username = true;
        }else{
            $out->username = false;
        }

        $email = PropUserQuery::create()->filterByEmail($data['email'], Criteria::EQUAL)->findOne();
        if(isset($email) === false && empty($email) === true){
            $out->email = true;
        }else{
            $out->email = false;
        }

        return $out;
    }

    /*
     * Setter's
     * */

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

    public function get_teacher_grades($teacher_id){
        return PropTeacherGradeQuery::create()->findByTeacherId($teacher_id);
    }
    public function get_teacher_by_email_or_username($string){
        $user = $this->get_teacher_by_username($string);

        if(empty($user) === true){
            $user = $this->get_teacher_by_email($string);
        }

        /*
         * check if user is teacher
         * */
        if(empty($user) === false){
            $teacher = PropTeacherQuery::create()->findOneByUserId($user->getUserId());

            if(empty($teacher) === false){
                return $user;
            }else{
                $user = null;
                return $user;
            }
        }else{
            return null;
        }
    }
    public function check_teacher_by_email($string){
        $user = $this->get_teacher_by_email($string);
        if(empty($user) === false){
            /*
             * check if user is teacher
             * */
            $teacher = PropTeacherQuery::create()->findOneByUserId($user->getUserId());

            if(empty($teacher) === false){
                return $user;
            }
            else{
                return null;
            }
        }

    }
    public function get_teacher_by_username($username){
        return PropUserQuery::create()->findOneByLogin($username);
    }
    public function get_teacher_by_email($email){
        return PropUserQuery::create()->findOneByEmail($email);
    }
    public function get_teacher_by_id($id){
        $teacher = PropTeacherQuery::create()->findOneByTeacherId($id);
        return PropUserQuery::create()->findOneByUserId($teacher->getUserId());
    }

    public function get_user_by_id($id){
        return PropUserQuery::create()->findOneByUserId($id);
    }

    public function get_user_type_by_id($id){
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

    public function get_teacher_count(){
        return PropTeacherQuery::create()->count();
    }

    public function get_teacher_biography_by_user_id($user_id){
        $teacher = PropTeacherQuery::create()->findOneByUserId($user_id);
        if (is_object($teacher) === true) {
            return $teacher->getBiography();
        } else {
            return null;
        }

    }

    public function get_state($user_id){
        $state = PropTeacherQuery::create()->findOneByUserId($user_id);
        if (is_object($state) === true) {
            if($state->getSchoolId() != 0){
                return $state->getPropSchool();
            }else{
                return false;
            }
        } else {
            return false;
        }
    }
}