<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 5/6/14
 * Time: 11:11 AM
 */
class Parent_google_model extends CI_Model {

    public function save($data, $id = null){
        if(empty($id)){
            $query = new PropParentsGoogle();
        }else{
            $query = PropParentsGoogleQuery::create()->findOneBySocGoogleId($id);

        }

        if(empty($data->parentId) === false){
            $query->setParentId($data->parentId);
        }
        if(empty($data->googleAuthCode) === false){
            $query->setGoogleAuthCode($data->googleAuthCode);
        }

        $query->save();

        return $query;
    }

    public function getByCode($code){
        return PropParentsGoogleQuery::create()->findOneByGoogleAuthCode($code);
    }
}