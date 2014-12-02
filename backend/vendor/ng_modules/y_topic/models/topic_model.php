<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 11/06/13
 * Time: 21:36 AM
 * To change this template use File | Settings | File Templates.
 */
class Topic_model extends CI_Model{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterName = null;
    private $filterSkillName = null;


    public function __construct(){
        parent::__construct();
    }

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterSkillName = null;
        $this->filterName = null;

        $this->total_rows = null;
    }

    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropTopicQuery::create();
        if (empty($this->filterName) === false) {
            $query->filterByName('%' . $this->filterName . '%', Criteria::LIKE);
        }
        if (empty($this->filterSkillName) === false) {
            $query->usePropSkillsQuery()->filterByName('%' . $this->filterSkillName . '%', Criteria::LIKE)->endUse();
        }

        return $query;
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

    public function filterByName($string){
        $this->filterName = $string;
    }
    public function filterBySkillName($string){
        $this->filterSkillName = $string;
    }

    public function is_unique_topic($topic_name){
        return PropTopicQuery::create()->findOneByName($topic_name);
    }

    /**
     * Getters
     */
    public function get_topic_by_id($id){
        return PropTopicQuery::create()->findOneByTopicId($id);
    }
    public function get_topic_name_by_topic_id($id){
        $t = PropTopicQuery::create()->findOneByTopicId($id);
        return $t->getName();
    }

    public function get_topic_by_skill_id($skill_id){
        return PropTopicQuery::create()->findBySkillId($skill_id);
    }
}