<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/12/13
 * Time: 4:12 PM
 * To change this template use File | Settings | File Templates.
 */
class Challenge_model extends CI_Model
{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;
    private $user_id = null;
    private $groupBy = null;
    private $filterNameChallenge = null;
    private $filterNameSubject = null;
    private $filterNameSkill = null;
    private $filterLevel = null;
    private $filterNameGame = null;
    private $filterNameGameLevel = null;
    private $filterNameTopic = null;
    private $filterClassId   = null;
    private $filterSubjectId = null;
    private $filterLevelId = null;

    private $singleChallenge = null;

    private $teacherId = null;


    public function __construct()
    {
        parent::__construct();
    }

    public function save($data , $id){

        if(empty($id) === true){
            $ch = new PropChallenge();
        }else{
            $ch = PropChallengeQuery::create()->findOneByChallengeId($id);
        }

        if (isset($data->name) === true) {
            $ch->setName($data->name);
        }
        if (isset($data->subject_id) === true) {
            $ch->setSubjectId($data->subject_id);
        }
        if (isset($data->skill_id) === true) {
            $ch->setSkillId($data->skill_id);
        }
        if (isset($data->topic_id) === true) {
            $ch->setTopicId($data->topic_id);
        }
        if (isset($data->level) === true) {
            $ch->setLevel($data->level);
        }
        if (isset($data->game_id) === true) {
            $ch->setGameId($data->game_id);
        }
        if (isset($data->gamelevel_id) === true) {
            $ch->setGamelevelId($data->gamelevel_id);
        }
        if (isset($data->description) === true) {
            $ch->setDescription($data->description);
        }
        if (isset($data->read_title) === true) {
            $ch->setReadTitle($data->read_title);
        }
        if (isset($data->read_image) === true) {
            $ch->setReadImage($data->read_image);
        }
        if (isset($data->read_text) === true) {
            $ch->setReadText($data->read_text);
        }

        if(isset($data->user_id) === true && empty($data->user_id) === false){
            $ch->setUserId($data->user_id);
        }

        if(isset($data->is_public) === true ){
            $ch->setIsPublic($data->is_public);
        }
        $ch->save();
        return $ch;
    }
    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;
        $this->groupBy = null;

        $this->filterNameChallenge = null;
        $this->filterNameSubject = null;
        $this->filterNameSkill = null;
        $this->filterLevel = null;
        $this->filterNameGame = null;
        $this->filterNameGameLevel = null;
        $this->filterNameTopic = null;
        $this->filterClassId = null;

        $this->$filterSubjectId = null;
        $this->filterLevelId = null;

        $this->singleChallenge = null;

        $this->teacherId = null;
        $this->user_id = null;

        $this->total_rows = null;
    }

    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropChallengeQuery::create();

        if(empty($this->teacherId) === false){
            $query->usePropChallengeClassQuery()
                ->usePropClasQuery()
                    ->filterByTeacherId($this->teacherId, Criteria::EQUAL)
                ->endUse()
            ->endUse();
        }

        if (empty($this->filterNameChallenge) === false) {
            $query->filterByName('%' . $this->filterNameChallenge . '%', Criteria::LIKE);
        }
        if (empty($this->filterNameSubject) === false) {
            $query->usePropSubjectsQuery()->filterByName('%' . $this->filterNameSubject . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->filterNameSkill) === false) {
            $query->usePropSkillsQuery()->filterByName('%' . $this->filterNameSkill . '%', Criteria::LIKE)->endUse();
        }
        if(empty($this->filterNameTopic) === false){
            $query->usePropTopicQuery()->filterByName("%" . $this->filterNameTopic . "%", Criteria::LIKE)->endUse();
        }
        if (empty($this->filterLevel) === false) {
            $query->filterByLevel('%' . $this->filterLevel . '%', Criteria::LIKE);
        }
        if (empty($this->filterNameGame) === false) {
            $query->usePropGamesQuery()->filterByName('%' . $this->filterNameGame . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->filterNameGameLevel) === false) {
            $query->usePropGameLevelsQuery()->filterByName('%' . $this->filterNameGameLevel . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->singleChallenge) === false) {
            $query->findOneByChallengeId($this->singleChallenge);
        }
        if(empty($this->filterSubjectId) === false){
            $query->filterBySubjectId($this->filterSubjectId);
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

    private function prepareListTeacherQuery(){

        $query = PropChallengeClassQuery::create()
            ->usePropClasQuery()
                ->filterByTeacherId(TeacherHelper::getId())
            ->endUse();

        if (empty($this->filterNameChallenge) === false) {
            $query->filterByName('%' . $this->filterNameChallenge . '%', Criteria::LIKE);
        }
        if (empty($this->filterNameSubject) === false) {
            $query->usePropSubjectsQuery()->filterByName('%' . $this->filterNameSubject . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->filterNameSkill) === false) {
            $query->usePropSkillsQuery()->filterByName('%' . $this->filterNameSkill . '%', Criteria::LIKE)->endUse();
        }
        if(empty($this->filterNameTopic) === false){
            $query->usePropTopicQuery()->filterByName("%" . $this->filterNameTopic . "%", Criteria::LIKE)->endUse();
        }
        if (empty($this->filterLevel) === false) {
            $query->filterByLevel('%' . $this->filterLevel . '%', Criteria::LIKE);
        }
        if (empty($this->filterNameGame) === false) {
            $query->usePropGamesQuery()->filterByName('%' . $this->filterNameGame . '%', Criteria::LIKE)->endUse();
        }
        if (empty($this->filterNameGameLevel) === false) {
            $query->usePropGameLevelsQuery()->filterByName('%' . $this->filterNameGameLevel . '%', Criteria::LIKE)->endUse();
        }
        if(empty($this->filterClassId) === false){
            $query->usePropClasQuery()->filterByClassId($this->filterClassId)->endUse();
        }

        return $query;
    }

    public function getListForTeacher(){
        $this->total_rows = $this->prepareListTeacherQuery()->count();

        $query = $this->prepareListTeacherQuery();
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

    public function set_group_by($field){
        $this->groupBy = $field;
    }
    public function set_offset($offset){
        $this->offset = $offset;
    }
    public function filterByNameChallenge($string){
        $this->filterNameChallenge = $string;
    }
    public function filterByNameSubject($string){
        $this->filterNameSubject = $string;
    }
    public function filterByNameSkill($string){
        $this->filterNameSkill = $string;
    }
    public function filterByNameTopic($string){
        $this->filterNameTopic = $string;
    }
    public function filterByLevel($string){
        $this->filterLevel = $string;
    }
    public function filterByNameGame($string){
        $this->filterNameGame = $string;
    }
    public function filterByNameGameLevel($string){
        $this->filterNameGameLevel = $string;
    }
    public function filterByTeacherId($id){
        $this->teacherId = $id;
    }
    public function filterByClassId($id){
        $this->filterClassId = $id;
    }
    public function filterBySubjectId($id){
        $this->filterSubjectId = $id;
    }
    public function filterByLevelId($id){
        $this->filterLevelId = $id;
    }
    /*
     * Setter's
     * */

    public function setTeacherId($id){
        $this->teacherId = $id;
    }

    public function setSingleChallenge($id){
        $this->singleChallenge = $id;
    }

    /*
     * Getter's
     * */

    public function get_subject(){
        $q = PropSubjectsQuery::create()->find();
        return $q;
    }
    public function get_skill($subject_id){
        $q = PropSkillsQuery::create()->filterBySubjectId($subject_id)->find();
        return $q;
    }
    public function get_topic($skill_id){
        $q = PropTopicQuery::create()->filterBySkillId($skill_id)->find();
        return $q;
    }
    public function get_game(){
        $q = PropGamesQuery::create()->find();
        return $q;
    }
    public function get_game_level($game_id){
        $q = PropGameLevelsQuery::create()->filterByGameId($game_id)->find();
        return $q;
    }
    public function get_challenge_by_id($id){
        $q = $this->db->where('challenges.challenge_id',$id)->get('challenges')->row();
        return $q;
    }

    public function getChallengeById($id)
    {
        return PropChallengeQuery::create()->findOneByChallengeId($id);
    }

    public function getTotalChallengeByTeacherId(){

        $class = PropClasQuery::create()->findByTeacherId($this->teacherId);
        $data = PropChallengeClassQuery::create()
                    ->filterByPropClas($class)
                ->count();
        return $data;
    }

    public function getTotalTeacherChallenges($user_id){
        return PropChallengeQuery::create()->filterByUserId($user_id)->count();
    }

    public function getTotalChallenges(){
        return PropChallengeQuery::create()->count();
    }

    public function get_teacher_name($user_id){
        $teacher_data = PropUserQuery::create()->findOneByUserId($user_id);
        if (is_object($teacher_data) === true) {
            return $teacher_data->getFirstName() . ' ' . $teacher_data->getLastName();
        }

    }

    public function get_challenge_played_times($challenge_id,$class_id = null){

        if ($class_id === null){
            $query = $this->db->query('SELECT  COUNT( scores.`student_id`) AS played_times
                                     FROM (`scores`)
                                     LEFT JOIN `challenge_classes` ON `challenge_classes`.`challenge_id` = scores.challenge_id
                                     LEFT JOIN `class_students` ON `challenge_classes`.`class_id` = `class_students`.`class_id`
                                     WHERE scores.challenge_id = '.$challenge_id.' AND `scores`.`student_id` = `class_students`.`student_id`');
        } else {
            $query = $this->db->query('SELECT  COUNT( scores.`student_id`) AS played_times
                                     FROM (`scores`)
                                     LEFT JOIN `challenge_classes` ON `challenge_classes`.`challenge_id` = scores.challenge_id
                                     LEFT JOIN `class_students` ON `challenge_classes`.`class_id` = `class_students`.`class_id`
                                     WHERE scores.challenge_id = '.$challenge_id.' AND challenge_classes.`class_id` = '.$class_id.' AND `scores`.`student_id` = `class_students`.`student_id`');
        }

        $rs = $query->row();
        return $rs->played_times;
    }

    /*
     * Function's
     * */

    public function delete_challenge_from_challenge_class($challclass_id){

        /*
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

    public function getCountQuestion (){

    }

    public function get_challenge_data($challenge_id){
        return PropChallengeQuery::create()->findOneByChallengeId($challenge_id);
    }

    public function get_challenge_name($challenge_id){
        $challenge = PropChallengeQuery::create()->findOneByChallengeId(intval($challenge_id));
        return $challenge->getName();
    }

    public function delete($challengeID){
        $challenge = PropChallengeQuery::create()->findOneByChallengeId($challengeID);
        $challenge->delete();
    }

    public function display_choice_image($challengeID)
    {
        $challenge = PropChallengeQuery::create()->findOneByChallengeId(intval($challengeID));
        return $challenge->getReadImage();
    }

    public function getClassScoreByChallengeAndClass($challengeId, $classId, $fromDate = null, $toDate = null){
        /*$classScore = $this->db->select_avg('score_average')
                                ->where('challenge_Id', $challengeId)
                                ->where('class_id',$classId)
                                ->get('scores')->row();
        return $classScore->score_average;*/

        $this->db->select_avg('score_average')
            ->where('challenge_Id', $challengeId)
            ->where('class_id',$classId);

	    if ($fromDate) {
		    $this->db->where('created >=', $fromDate);
	    }

	    if ($toDate) {
		    $this->db->where('created <=', $toDate);
	    }

	    $query = $this->db->get('scores')->row();
        return $query->score_average;
    }

    public function getGlobalClassScoreByChallenge($challengeId){
        $globalScore = $this->db->select_avg('score_average')
            ->where('challenge_id', $challengeId)
            ->get('scores')->row();
        return $globalScore->score_average;
    }
}