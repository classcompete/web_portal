<?php
/**
 * Wrapper for Propel model of User_activity table.
 * - Logs user's last action and it's time
 */

class User_activity_model extends CI_model {

	protected $orderBy = null;
    protected $orderByDirection = null;
    protected $limit = null;
    protected $offset = null;
	protected $totalRows;

    protected $filterUpdatedAt = null;

    public function __construct() {
        parent::__construct();
    }

    public function save($data, $id) {
        if (empty($id)) { $activity = new PropUserActivity(); }
        else { $activity = PropUserActivityQuery::create()->findOneByUserActivityId($id); }

	    if (isset($data->user_id)) { $activity->setUserId($data->user_id); }
	    if (isset($data->last_action)) { $activity->setLastAction($data->last_action); }

        $activity->save();
        return $activity;
    }

        //***************************************************
        // FILTERS
        //***************************************************

    public function resetFilters() {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;
		$this->totalRows = null;

        $this->filterUpdatedAt = null;
    }

    public function getFoundRows() { return (int)$this->totalRows; }

    private function prepareListQuery() {
        $query = PropUserActivityQuery::create();

        if (! empty($this->filterUpdatedAt)) {
	        $query->filterByUpdatedAt($this->filterUpdatedAt, Criteria::GREATER_EQUAL);
        }

        return $query;
    }

    public function getList() {
        $this->totalRows = $this->prepareListQuery()->count();
        $query = $this->prepareListQuery();

        if (! empty($this->orderBy)) {
	        $query->orderBy($this->orderBy, $this->orderByDirection);
        }
        $query->limit($this->limit);
        $query->offset($this->offset);
        return $query->find();
    }

    public function set_order_by($field) { $this->orderBy = $field; }
    public function set_order_by_direction($direction) { $this->orderByDirection = $direction; }
    public function set_limit($limit) { $this->limit = $limit; }
    public function set_offset($offset) { $this->offset = $offset; }

    public function filterByUpdatedAt($minutesOffset) {
	    $this->filterUpdatedAt = date('Y-m-d H:i:s', strtotime('-' . $minutesOffset . ' minutes'));
    }

        //***************************************************
        // SEARCH
        //***************************************************

    public function getUserActivityById($userActivityId) {
        return PropUserActivityQuery::create()->findOneByUserActivityId($userActivityId);
    }

    public function getUserActivityByUserId($userId) {
        return PropUserActivityQuery::create()->findOneByUserId($userId);
    }

}