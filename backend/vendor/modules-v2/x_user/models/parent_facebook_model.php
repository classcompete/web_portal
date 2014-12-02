<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 5/6/14
 * Time: 11:11 AM
 */
class Parent_facebook_model extends CI_Model {

    public function save($data, $id = null){
        if(empty($id)){
            $query = new PropParentsFacebook();
        }else{
            $query = PropParentsFacebookQuery::create()->findOneBySocFacebookId($id);
        }

        if(empty($data->parentId) === false){
            $query->setParentId($data->parentId);
        }
        if(empty($data->facebookAuthCode) === false){
            $query->setFacebookAuthCode($data->facebookAuthCode);
        }

        $query->save();

        return $query;
    }

    public function getByCode($code){
        return PropParentsFacebookQuery::create()->findOneByFacebookAuthCode($code);
    }
}