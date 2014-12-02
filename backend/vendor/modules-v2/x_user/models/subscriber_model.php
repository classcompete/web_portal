<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 5/6/14
 * Time: 12:17 PM
 */
class SubScriber_model extends CI_Model {


    public function save($data, $id = null){
        if(empty($id)){
            $query = new PropSubscriber();
        }else{
            $query = PropSubscriberQuery::create()->findOneById($id);
        }

        if(empty($data->email) === false){
            $query->setEmail($data->email);
        }

        $query->save();
        return $query;
    }

    public function getByEmail($email){
        return PropSubscriberQuery::create()->findOneByEmail($email);
    }

}