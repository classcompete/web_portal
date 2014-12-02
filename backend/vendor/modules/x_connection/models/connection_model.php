<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/19/13
 * Time: 3:20 PM
 * To change this template use File | Settings | File Templates.
 */
class Connection_model extends CI_Model
{

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterFromUserLogin = null;
    private $filterToUserLogin = null;
    private $filterStatus = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id)
    {
        if (empty($id) === true) {
            $conn = new PropConnection();
        } else {
            $conn = PropConnectionQuery::create()->findOneByConnId($id);
        }
        if (isset($data->from_user_id) === true && empty($data->from_user_id) === false) {
            $conn->setFromUserId($data->from_user_id);
        }
        if (isset($data->to_user_id) === true && empty($data->to_user_id) === false) {
            $conn->setToUserId($data->to_user_id);
        }
        if (isset($data->status) === true && empty($data->status) === false) {
            $conn->setStatus($data->status);
        }

        /*
         * if empty add date to created
         * */
        if (empty($id) === true) {
            $conn->setCreated(date('Y-m-d H:i:s'));
        } /*
         * else update modified
         * */
        else {
            $conn->setModified(date('Y-m-d H:i:s'));
        }

        $conn->save();

        return $conn;
    }

    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterFromUserLogin = null;
        $this->filterToUserLogin = null;
        $this->filterStatus = null;

        $this->total_rows = null;
    }

    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropConnectionQuery::create();

        if (empty($this->filterFromUserLogin) === false) {
            $query->usePropUserRelatedByFromUserIdQuery()->filterByLogin('%' . $this->filterFromUserLogin . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->filterToUserLogin) === false) {
            $query->usePropUserRelatedByToUserIdQuery()->filterByLogin('%' . $this->filterToUserLogin . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->filterStatus) === false) {
            $query->filterByStatus('%' . $this->filterStatus . '%', Criteria::LIKE);
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

    public function get_user_exclude_by_id($id)
    {
        return PropUserQuery::create()->filterByUserId($id, Criteria::NOT_EQUAL)->find();
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

    public function filterByStatus($string)
    {
        $this->filterStatus = $string;
    }

    public function filterByFromUserLogin($string)
    {
        $this->filterFromUserLogin = $string;
    }

    public function filterByToUserLogin($string)
    {
        $this->filterToUserLogin = $string;
    }

    public function get_connection_by_id($id)
    {
        return BasePropConnectionQuery::create()->findOneByConnId($id);
    }
}