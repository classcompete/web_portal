<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 07/11/13
 * Time: 16:47
 */
class Marketplace_model extends CI_Model{

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterLevel = null;

    public function __construct(){
        parent:: __construct();
    }

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterLevel = null;

        $this->total_rows = null;
    }

    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropChallengeQuery::create();

        $query->filterByIsPublic(PropChallengePeer::IS_PUBLIC_YES);

        if(isset($this->filterLevel) === true && empty($this->filterLevel) === false){
            $query->filterByLevel($this->filterLevel, Criteria::EQUAL);
        }

        return $query->setDistinct();
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

    /**
     * Setter's
     * */

    public function set_filter_by_level($string){
        $this->filterLevel = $string;
    }

}