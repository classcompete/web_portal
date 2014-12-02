<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/22/13
 * Time: 10:51 AM
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

    public function save($data, $id){

        if(empty($id) === true){
            $topic = new PropTopic();
        }else{
            $topic = PropTopicQuery::create()->findOneByTopicId($id);
        }
        if(isset($data->name) === true && empty($data->name) === false){
            $topic->setName($data->name);
        }
        if(isset($data->skill_id) === true && empty($data->skill_id) === false){
            $topic->setSkillId($data->skill_id);
        }

        $topic->save();

        return $topic;
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

    public function get_topic_by_id($id)
    {
        return BasePropTopicQuery::create()->findOneByTopicId($id);
    }

    public function is_unique_topic($topic_name){
        return PropTopicQuery::create()->findOneByName($topic_name);
    }
}