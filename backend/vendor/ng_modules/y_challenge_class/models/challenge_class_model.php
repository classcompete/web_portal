<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 23:38
 */
class Challenge_class_model extends CI_Model{

    private $orderBy            = null;
    private $orderByDirection   = null;
    private $limit              = null;
    private $offset             = null;

    private $filterChallengeName    = null;
    private $filterClassName        = null;
    private $filterClassId          = null;
    private $filterChallengeId      = null;

    private $teacher_id = null;

    public function __construct(){parent::__construct();}

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
        $this->filterClassName = null;
        $this->filterChallengeName = null;
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

    public function filterByTeacherId($id){
        $this->teacher_id = $id;
    }

    public function filterByClassId($class_id){
        $this->filterClassId = $class_id;
    }

    public function filterByChallengeId($challenge_id){
        $this->filterChallengeId = $challenge_id;
    }

    /**
     *  Functions
     */
    public function delete_challenge($challclass_id){

        /**
         * Check if we have this id
         * */
        $check = PropChallengeClassQuery::create()->findOneByChallclassId($challclass_id);

        if($check != null){
            $query = PropChallengeClassQuery::create()->findOneByChallclassId($challclass_id);
            $query->delete();
            $check = $query->isDeleted();
        }else{
            $check = false;
        }

        return $check;

    }

    /**
     * Getter's
     * */
    public function get_challenges_id_by_class($class_id){
        return PropChallengeClassQuery::create()->filterByClassId($class_id)->find();
    }
}