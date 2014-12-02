<?php
class Parent_student_connection_model extends CI_Model
{

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterParentUsername = null;
    private $filterStudentUsername = null;

    public function __construct()
    {
        parent::__construct();
    }

//    public function save($data, $id)
//    {
//        if (empty($id) === true) {
//            $conn = new PropParentStudents();
//        } else {
//            $conn = PropParentStudentsQuery::create()->findOneById($id);
//        }
//        if (isset($data->from_user_id) === true && empty($data->from_user_id) === false) {
//            $conn->setFromUserId($data->from_user_id);
//        }
//        if (isset($data->to_user_id) === true && empty($data->to_user_id) === false) {
//            $conn->setToUserId($data->to_user_id);
//        }
//        if (isset($data->status) === true && empty($data->status) === false) {
//            $conn->setStatus($data->status);
//        }
//
//        /*
//         * if empty add date to created
//         * */
//        if (empty($id) === true) {
//            $conn->setCreated(date('Y-m-d H:i:s'));
//        } /*
//         * else update modified
//         * */
//        else {
//            $conn->setModified(date('Y-m-d H:i:s'));
//        }
//
//        $conn->save();
//
//        return $conn;
//    }

    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterParentUsername = null;
        $this->filterStudentUsername = null;

        $this->total_rows = null;
    }

    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropParentStudentsQuery::create();

        if (empty($this->filterParentUsername) === false) {
            $query->usePropParentQuery()->usePropUserQuery()->filterByLogin('%' . $this->filterParentUsername . '%', Criteria::LIKE)->endUse()->endUse();
        }
        if (empty($this->filterStudentUsername) === false) {
            $query->usePropStudentQuery()->usePropUserQuery()->filterByLogin('%' . $this->filterStudentUsername . '%', Criteria::LIKE)->endUse()->endUse();
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

    public function get_all_users()
    {
        return PropUserQuery::create()->find();
    }

//    public function get_user_exclude_by_id($id)
//    {
//        return PropUserQuery::create()->filterByUserId($id, Criteria::NOT_EQUAL)->find();
//    }

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

    public function filterByParentUsername($string)
    {
        $this->filterParentUsername = $string;
    }

    public function filterByStudentUsername($string)
    {
        $this->filterStudentUsername = $string;
    }

    public function get_parent_student_connection_by_id($id)
    {
        return PropParentStudentsQuery::create()->findOneById($id);
    }

    public function delete_by_id($id)
    {
        $connection = PropParentStudentsQuery::create()->findOneById($id);

        if (empty($connection) === false){
            $connection->delete();
            $out = $connection->isDeleted();
        } else {
            $out = null;
        }

        return $out;
    }
}