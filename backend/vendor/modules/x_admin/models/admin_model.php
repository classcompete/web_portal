<?php

class Admin_model extends CI_Model
{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterUsername = null;
    private $filterFirstName = null;
    private $filterLastName = null;
    private $filterEmail = null;

    private $excludeId = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id = null)
    {
        if (empty($id) === true) {
            $admin = new PropAdmin();
        } else {
            $admin = PropAdminQuery::create()->findOneById($id);
        }
        if (isset($data->username) === true && empty($data->username) === false) {
            $admin->setUsername($data->username);
        }
        if (isset($data->email) === true && empty($data->email) === false) {
            $admin->setEmail($data->email);
        }
        if (isset($data->password) === true && empty($data->password) === false) {
            $admin->setPassword($data->password);
        }
        if (isset($data->first_name) === true && empty($data->first_name) === false) {
            $admin->setFirstName($data->first_name);
        }
        if (isset($data->last_name) === true && empty($data->last_name) === false) {
            $admin->setLastName($data->last_name);
        }
        $admin->save();
        return $admin;
    }

    public function delete($id)
    {
        if (empty($id) === true) {
            return false;
        } else {
            $admin = new PropAdmin();
            $admin->setId($id);
            $admin->delete();
            return $admin;
        }
    }

    public function update_admin_login(PropAdmin $admin)
    {
        $admin->setLastLoginTime(date("Y-m-d H:i:s"));
        $admin->save();
        return $admin;
    }

    public function get_admin_by_email_or_username($string)
    {
        $admin = $this->get_admin_by_username($string);
        if (empty($admin) === true) {
            $admin = $this->get_admin_by_email($string);
        }
        return $admin;
    }

    public function check_admin_by_email($string){
            $admin = $this->get_admin_by_email($string);
        return $admin;
    }

    public function is_unique_username_and_email($username, $email, $excludeId = null)
    {
        $userCount = PropAdminQuery::create()
            ->filterById($excludeId, Criteria::NOT_EQUAL)
            ->condition('username', PropAdminPeer::USERNAME . ' = ?', $username)
            ->condition('email', PropAdminPeer::EMAIL . ' = ?', $email)
            ->combine(array('username', 'email'), Criteria::LOGICAL_OR)
            ->count();
        $isUnique = empty($userCount);
        return $isUnique;
    }

    public function get_admin_by_username($username)
    {
        return PropAdminQuery::create()->findOneByUsername($username);
    }

    public function get_admin_by_email($email)
    {
        return PropAdminQuery::create()->findOneByEmail($email);
    }

    public function get_admin_by_id($id)
    {
        return PropAdminQuery::create()->findOneById($id);
    }

    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterUsername = null;
        $this->filterEmail = null;
        $this->filterFirstName = null;
        $this->filterLastName = null;

        $this->excludeId = null;

        $this->total_rows = null;
    }

    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropAdminQuery::create();
        if (empty($this->filterUsername) === false) {
            $query->filterByUsername('%' . $this->filterUsername . '%', Criteria::LIKE);
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
            $query->filterById($this->excludeId, Criteria::NOT_EQUAL);
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

    public function filterByUsername($string)
    {
        $this->filterUsername = $string;
    }

    public function filterByEmail($string)
    {
        $this->filterEmail = $string;
    }

    public function excludeById($id)
    {
        $this->excludeId = $id;
    }

    public function filterByFirstName($string){
        $this->filterFirstName = $string;
    }

    public function filterByLastName($string){
        $this->filterLastName = $string;
    }

}