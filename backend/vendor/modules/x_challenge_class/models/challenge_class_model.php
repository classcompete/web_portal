<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/15/13
 * Time: 10:46 AM
 * To change this template use File | Settings | File Templates.
 */
class Challenge_class_model extends CI_Model{

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterChallengeName = null;
    private $filterClassName = null;
    private $filterClassId = null;
    private $teacher_id = null;
    private $filterChallengeId = null;

    public function __construct(){
        parent::__construct();
    }

    public function save($data, $id){
        if(empty($id) === true){
            $ch_class = new PropChallengeClass();
        }else{
            $ch_class = PropChallengeClassQuery::create()->findOneByChallclassId($id);
        }
        if(empty($data->challenge_id) === false && isset($data->challenge_id) === true){
            $ch_class->setChallengeId($data->challenge_id);
        }
        if(empty($data->class_id) === false && isset($data->class_id) === true){
            $ch_class->setClassId($data->class_id);
        }
        $ch_class->save();
        return $ch_class;

    }

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->teacher_id = null;
        $this->filterClassId = null;
        $this->filterChallengeId = null;

        $this->total_rows = null;
    }

    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropChallengeClassQuery::create();
        if (empty($this->filterChallengeName) === false) {
            $query->usePropChallengeQuery()->filterByName('%' . $this->filterChallengeName . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->filterClassName) === false) {
            $query->usePropClasQuery()->filterByName('%' . $this->filterClassName . '%', Criteria::LIKE)->endUse();
        }
        if(empty($this->teacher_id) === false){
            $query->usePropClasQuery()->filterByTeacherId($this->teacher_id)->endUse();
        }
        if(empty($this->filterClassId) === false){
            $query->filterByClassId($this->filterClassId);
        }
        if(empty($this->filterChallengeId) === false){
            $query->filterByChallengeId($this->filterChallengeId);
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
    public function filterByNameChallenge($string){
        $this->filterChallengeName = $string;
    }
    public function filterByNameClass($string){
        $this->filterClassName = $string;
    }
    public function filterByClassId($id){
        $this->filterClassId = $id;
    }
    public function filterByChallengeId($id){
        $this->filterChallengeId = $id;
    }


    /*
     * Getter's
     * */

    public function get_challenges(){
        $challenges = PropChallengeQuery::create()->find();
        return $challenges;
    }
    public function get_classes(){
        if(empty($this->teacher_id) === true){
            /*
             * get all classes
             * */
            $classes = PropClasQuery::create()->find();
        }else{
            /*
             * get current teacher class
             * */
            $classes = PropClasQuery::create()->findByTeacherId($this->teacher_id);
        }

        return $classes;
    }

    public function get_challenge_class_by_id($id){
        return PropChallengeClassQuery::create()->findOneByChallclassId($id);
    }

    public function get_challenges_id_by_class($class_id){
        return PropChallengeClassQuery::create()->filterByClassId($class_id)->find();
    }

    /*
     * Setter's
     * */
    public function setTeacherId($id){
        $this->teacher_id = $id;
    }

}