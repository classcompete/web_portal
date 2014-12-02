<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/10/14
 * Time: 4:45 PM
 */
class Parent_model extends CI_model{
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


    public function __construct(){
        parent::__construct();
    }

    public function resetFilters(){
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

    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropParentQuery::create();


        if (empty($this->filterUsername) === false) {
            $query->usePropUserQuery()
                        ->filterByLogin('%' . $this->filterUsername . '%', Criteria::LIKE)
                    ->endUse();
        }
        if (empty($this->filterEmail) === false) {
            $query->usePropUserQuery()
                    ->filterByEmail('%' . $this->filterEmail . '%', Criteria::LIKE)
                ->endUse();
        }
        if (empty($this->filterFirstName) === false) {
            $query->usePropUserQuery()
                    ->filterByFirstName('%' . $this->filterFirstName . '%', Criteria::LIKE)
                ->endUse();
        }
        if (empty($this->filterLastName) === false) {
            $query->usePropUserQuery()
                    ->filterByLastName('%' . $this->filterLastName . '%', Criteria::LIKE)
                ->endUse();
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

    public function filterByLogin($string){
        $this->filterUsername = $string;
    }

    public function filterByEmail($string){
        $this->filterEmail = $string;
    }

    public function filterByFirstName($string){
        $this->filterFirstName = $string;
    }

    public function filterByLastName($string){
        $this->filterLastName = $string;
    }

    public function is_parent($user_id){
        $parents = PropParentQuery::create()->findOneByUserId($user_id);
        if(empty($parents) == true){
            return false;
        } else {
            return true;
        }
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

        if (empty($id) === true) {
            $parent = new PropParent();
            $parent->setPropUser($user);
            if (isset($data->avatar) === true && empty($data->avatar) === false){
                $parent->setImageThumb($data->avatar);
            }
            $parent->save();

        } else {

            $parent = PropParentQuery::create()->findOneByUserId(intval($id));
            $parent->setPropUser($user);
            $parent->setModified(date("Y-m-d H:i:s"));

            if (isset($data->avatar) === true && empty($data->avatar) === false){
                $parent->setImageThumb($data->avatar);
            }

            $parent->save();
        }
        return $user;
    }
}