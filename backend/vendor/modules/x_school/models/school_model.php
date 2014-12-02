<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/23/13
 * Time: 5:44 PM
 * To change this template use File | Settings | File Templates.
 */
class School_model extends CI_Model{

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterName = null;
    private $filterState = null;
    private $filterCountry = null;
    private $filterCity = null;
    private $filterCounty = null;
    private $filterZipCode = null;
    private $filterApproved = null;
    private $filterPublic = null;

    public function __construct(){
        parent::__construct();
    }

    public function save($data, $id){
        if(empty($id) === true){
            $school = new PropSchool();
        }else{
            $school = PropSchoolQuery::create()->findOneBySchoolId($id);
        }
        if(isset($data->name) === true && empty($data->name) === false){
            $school->setName($data->name);
        }
        if(isset($data->state) === true && empty($data->state) === false){
            $school->setState($data->state);
        }
        if(isset($data->country) === true && empty($data->country) === false){
            $school->setCountry($data->country);
        }
        if(isset($data->city) === true && empty($data->city) === false){
            $school->setCity($data->city);
        }
        if(isset($data->county) === true && empty($data->county) === false){
            $school->setCounty($data->county);
        }
        if(isset($data->zip_code) === true && empty($data->zip_code) === false){
            $school->setZipCode($data->zip_code);
        }
        if(isset($data->approved) === true && empty($data->approved) === false){
            if($data->approved === PropSchoolPeer::APPROVED_APPROVED){
                $school->setApproved(PropSchoolPeer::APPROVED_APPROVED);
            }else{
                $school->setApproved(PropSchoolPeer::APPROVED_NOT_APPROVED);
            }
        }
        if(isset($data->public) === true && empty($data->public) === false){

            if($data->public === PropSchoolPeer::IS_PUBLIC_PUBLIC){
                $school->setIsPublic(PropSchoolPeer::IS_PUBLIC_PUBLIC);

            }else{
                $school->setIsPublic(PropSchoolPeer::IS_PUBLIC_PRIVATE);
            }
        }

        $school->save();
        return $school;


    }

    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterName = null;
        $this->filterState = null;
        $this->filterCountry = null;
        $this->filterCity = null;
        $this->filterCounty = null;
        $this->filterZipCode = null;
        $this->filterApproved = null;
        $this->filterPublic = null;


        $this->total_rows = null;
    }


    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropSchoolQuery::create();
        if (empty($this->filterName) === false) {
            $query->filterByName('%' . $this->filterName . '%', Criteria::LIKE);
        }
        if (empty($this->filterState) === false) {
            $query->filterByState('%' . $this->filterState . '%', Criteria::LIKE);
        }
        if (empty($this->filterCountry) === false) {
            $query->filterByCountry('%' . $this->filterCountry . '%', Criteria::LIKE);
        }
        if (empty($this->filterCity) === false) {
            $query->filterByCity('%' . $this->filterCity . '%', Criteria::LIKE);
        }
        if (empty($this->filterCounty) === false) {
            $query->filterByCounty('%' . $this->filterCounty . '%', Criteria::LIKE);
        }
        if (empty($this->filterZipCode) === false) {
            $query->filterByZipCode('%' . $this->filterZipCode . '%', Criteria::LIKE);
        }
        if (empty($this->filterApproved) === false) {
            $query->filterByApproved($this->filterApproved, Criteria::LIKE);
        }
        if (empty($this->filterPublic) === false) {

                $query->filterByIsPublic($this->filterPublic, Criteria::LIKE);


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

    public function filterByName($string){
        $this->filterName = $string;
    }

    public function filterByState($string){

        $this->filterState = $string;
    }
    public function filterByCountry($string){
        $this->filterCountry = $string;
    }
    public function filterByCity($string){
        $this->filterCity = $string;
    }
    public function filterByCounty($string){
        $this->filterCounty = $string;
    }
    public function filterByZipCode($string){
        $this->filterZipCode = $string;
    }
    public function filterByApproved($string){
        if($string === 'approved'){
            $this->filterApproved = PropSchoolPeer::APPROVED_APPROVED;
        }else{
            $this->filterApproved = PropSchoolPeer::APPROVED_NOT_APPROVED;
        }
    }
    public function filterByIsPublic($string){
        if($string === 'private'){
            $this->filterPublic = PropSchoolPeer::IS_PUBLIC_PRIVATE;
        }else{
            $this->filterPublic = PropSchoolPeer::IS_PUBLIC_PUBLIC;
        }
    }
    public function get_school($school_id){
        return PropSchoolQuery::create()->findOneBySchoolId($school_id);
    }


    /**
     * function for delcine school - delete form school table and unset teachers school_id to 0
     * @params: school_id
     */
    public function decline_school($school_id){

        /** delete school from school table */
        $school = PropSchoolQuery::create()->findOneBySchoolId($school_id);
        $school->delete();

        /** unset teacher's school_id to 0 */

        $teachers = PropTeacherQuery::create()->filterBySchoolId($school_id)->find();

        foreach($teachers as $teacher=>$val){
            $val->setSchoolId(0);
        }
        $teachers->save();

        return $school;
    }

    public function approve_school($school_id){
        $school = PropSchoolQuery::create()->findOneBySchoolId($school_id);
        $school->setApproved(PropSchoolPeer::APPROVED_APPROVED);
        $school->save();
        return $school;
    }

    /**
     * Function for filtering school for auto complete
     * $params: string
     * $out:    array
     * */
    public function find_school($school_name, $zip_code){
        $query = $this->db->select('school_id, name')
                        ->limit(50)
                        ->where('zip_code',intval($zip_code))
                        ->where('approved',1)
                        ->like('name',$school_name)
                        ->get('school')->result_array();

        return $query;
    }
}