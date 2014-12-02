<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 1:06 PM
 */
class Facebook_connection_model extends CI_Model{
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
        $query = PropParentsFacebookQuery::create();

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

        $parent_fb = new PropParentsFacebook();

        $parent_fb->setParentId($parent_id);
        $parent_fb->setFacebookAuthCode($data->code);

        $parent_fb->save();
    }

    public function delete($network, $parent_id){
        $parent_google = PropParentsFacebookQuery::create()->findOneByParentId($parent_id);
        $parent_google->delete();
    }
    public function getUserByCode($code){
        $parent_soc_connection =  PropParentsFacebookQuery::create()->findOneByFacebookAuthCode($code);
        if($parent_soc_connection != null){
            return $parent_soc_connection->getPropParents()->getPropUser();
        }
    }
}