<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/1/14
 * Time: 2:48 PM
 */
class Parent_model extends CI_Model{


    public function __construct(){
        parent::__construct();
    }

    public function save($data, $id = null){
        if(empty($id)){
            $parent = new PropParent();
        }else{
            $parent = PropParentQuery::create()->findOneByUserId($id);
        }

        if(empty($data->userId) === false){
            $parent->setUserId($data->userId);
        }
        if(empty($data->authCode) === false){
            $parent->setAuthCode($data->authCode);
        }
        if(empty($data->timeDiff) === false){
            $parent->setTimeDiff($data->timeDiff);
        }
        if(empty($data->country) === false){
            $parent->setCountry($data->country);
        }
        if(empty($data->postalCode) === false){
            $parent->setPostalCode($data->postalCode);
        }
        if(empty($data->viewIntro) === false){
            $parent->setViewIntro($data->viewIntro);
        }

        $parent->save();

        return $parent;
    }

    public function getParentByUserId($userId){
        return PropParentQuery::create()->findOneByUserId($userId);
    }
    public function getByParentId($id){
        return PropParentQuery::create()->findOneByParentId($id);
    }
    public function getParentByAuthCode($authCode){
        return PropParentQuery::create()->findOneByAuthCode($authCode);
    }

}