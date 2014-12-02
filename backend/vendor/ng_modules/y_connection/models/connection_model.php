<?php
class Connection_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id = null)
    {
        if (empty($id) === true) {
            $connection = new PropParentStudents();
        } else {
            $connection = PropParentStudentsQuery::create()->findOneById($id);
        }

        if (isset($data->parent_id) === true && empty($data->parent_id) === false) {
            $connection->setParentId($data->parent_id);
        }

        if (isset($data->student_id) === true && empty($data->student_id) === false) {
            $connection->setStudentId($data->student_id);
        }

        $connection->save();

        return $connection;
    }

    public function get_connection_by_parent_id($parent_id)
    {
        return PropParentStudentsQuery::create()->findOneByParentId($parent_id);
    }

    public function get_connection_by_student_id($student_id)
    {
        return PropParentStudentsQuery::create()->findOneByStudentId($student_id);
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