<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 12:53 PM
 */
class Google_connection_model extends CI_Model{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;


    public function __construct(){parent::__construct();}

    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->total_rows = null;
    }
    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropParentsGoogleQuery::create();

        $query->filterByParentId(ParentHelper::getId(), Criteria::EQUAL);

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
    public function save($data, $parent_id){

        $parent_google = new PropParentsGoogle();

        $parent_google->setParentId($parent_id);
        $parent_google->setGoogleAuthCode($data->code);

        $parent_google->save();
    }

    public function delete($network, $parent_id){
        $parent_google = PropParentsGoogleQuery::create()->findOneByParentId($parent_id);
        $parent_google->delete();
    }

    public function getUserByCode($code){
        $parent_soc_connection =  PropParentsGoogleQuery::create()->findOneByGoogleAuthCode($code);
        if($parent_soc_connection != null){
            return $parent_soc_connection->getPropParents()->getPropUser();
        }
    }
}