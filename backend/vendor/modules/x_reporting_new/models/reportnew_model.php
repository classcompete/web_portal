<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/29/14
 * Time: 1:24 PM
 */
class Reportnew_model extends CI_Model{

    private $orderBy = null;
    private $orderByDirection = null;
    private $groupBy = null;
    private $limit = null;
    private $offset = null;

    private $filterStudentId = null;
    private $filterChallengeId = null;
    private $filterClassId = null;

    public function __construct(){
        parent::__construct();
    }

    public function save($data, $id){
        if(empty($id) === true){
            $game = new PropScoreQuery();
        }else{
            $game = PropScoreQuery::create()->findOneByGameId($id);
        }
        $game->save();
        return $game;
    }
    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;
        $this->groupBy = null;

        $this->filterStudentId = null;
        $this->filterChallengeId = null;
        $this->filterClassId = null;


        $this->total_rows = null;
    }
    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropScoreQuery::create();
        if (empty($this->filterStudentId) === false) {
            $query->filterByStudentId($this->filterStudentId);
        }
        if(empty($this->filterChallengeId) === false){
            $query->filterByChallengeId($this->filterChallengeId);
        }
        if(empty($this->filterClassId) === false){
            $query->filterByClassId($this->filterClassId);
        }
        return $query;
    }

    public function getList(){
        $this->total_rows = $this->prepareListQuery()->count();

        $query = $this->prepareListQuery();
        if (empty($this->orderBy) === false) {
            $query->orderBy($this->orderBy, $this->orderByDirection);
        }
        if(empty($this->groupBy) === false){
            $query->groupBy($this->groupBy);
        }
        $query->limit($this->limit);
        $query->offset($this->offset);

        return $query->find();
    }

    public function getStudentGlobalScoreChallengeInClass($student_id, $class_id){
        $cu = new Criteria();
        $cu->clearSelectColumns();
        $cu->add(PropScorePeer::CLASS_ID, $class_id);
        $cu->add(PropScorePeer::STUDENT_ID, $student_id);
        $cu->addSelectColumn(PropScorePeer::CHALLENGE_ID);
        $cu->addSelectColumn('AVG('.PropScorePeer::SCORE_AVERAGE.') AS average');
        $cu->addGroupByColumn(PropScorePeer::CHALLENGE_ID);
        $sumy = PropScorePeer::doSelectStmt($cu);

        $formatedData = array();
        while($row = $sumy->fetch(PDO::FETCH_OBJ)){
            $formatedData[$row->CHALLENGE_ID] = array();
            $formatedData[$row->CHALLENGE_ID]['score'] = $row->average;
        }
        return $formatedData;
    }

    public function getAllStudentsGlobalScoreChallengeInClass($class_id){
        $cu = new Criteria();
        $cu->clearSelectColumns();
        $cu->add(PropScorePeer::CLASS_ID, $class_id);
        $cu->addSelectColumn(PropScorePeer::CHALLENGE_ID);
        $cu->addSelectColumn('AVG('.PropScorePeer::SCORE_AVERAGE.') AS average');
        $cu->addGroupByColumn(PropScorePeer::CHALLENGE_ID);
        $sumy = PropScorePeer::doSelectStmt($cu);

        $formatedData = array();
        while($row = $sumy->fetch(PDO::FETCH_OBJ)){
            $formatedData[$row->CHALLENGE_ID] = array();
            $formatedData[$row->CHALLENGE_ID]['score'] = $row->average;
        }
        return $formatedData;
    }

    public function getAllStudentGlobalChallengeScore(){
        $cu = new Criteria();
        $cu->clearSelectColumns();
        $cu->addSelectColumn(PropScorePeer::CHALLENGE_ID);
        $cu->addSelectColumn('AVG('.PropScorePeer::SCORE_AVERAGE.') AS average');
        $cu->addGroupByColumn(PropScorePeer::CHALLENGE_ID);
        $cu->addOr(PropScorePeer::CLASS_ID, 0, Criteria::NOT_EQUAL);
        $cu->addOr(PropScorePeer::CLASS_ID, NULL, Criteria::NOT_EQUAL);
        $sumy = PropScorePeer::doSelectStmt($cu);

        $formatedData = array();
        while($row = $sumy->fetch(PDO::FETCH_OBJ)){
            $formatedData[$row->CHALLENGE_ID] = array();
            $formatedData[$row->CHALLENGE_ID]['score'] = $row->average;
        }
        return $formatedData;
    }

    public function get_amount_statistic_for_specific_class($class){
        $query = $this->db->select('AVG(score_average) AS average')
                        ->where('class_id',$class)
                        ->get('scores')->row();

        return $query->average;
    }

    public function get_student_coins_from_shop_transaction($created,$student,$class,$challenge){
        $shop_transaction = PropShopTransactionQuery::create()
            ->filterByCreated($created)
            ->filterByStudentId($student)
            ->filterByClassId($class)
            ->filterByChallengeId($challenge)
            ->find();

        return $shop_transaction;
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

    public function set_offset($offset)
    {
        $this->offset = $offset;
    }

    public function set_group_by($field){
        $this->groupBy = $field;
    }

    public function filterByClassId($id){
        $this->filterClassId = $id;
    }

    public function filterByStudentId($id){
        $this->filterStudentId = $id;
    }

    public function filterByChallengeId($id){
        $this->filterChallengeId = $id;
    }

}