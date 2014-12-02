<?php

class Admin_token_model extends CI_Model{

    public function save($admin, $ttl, $token_string, $type){
        $token = PropAdminTokenQuery::create()->filterByType($type)->findOneByToken($token_string);
        if(empty($token) === true){
            $token = new PropAdminToken();
            $token->setToken($token_string);
            $token->setType($type);
        }
        $token->setAdminId($admin->getId());
        $token->setTtl($ttl);
        $token->save();

        return $token;
    }

    public function get_by_type($token,$type){
        return PropAdminTokenQuery::create()->filterByType($type)->findOneByToken($token);
    }

    public function destroy($token, $type){
        PropAdminTokenQuery::create()->filterByToken($token)->filterByType($type)->delete();
    }
}