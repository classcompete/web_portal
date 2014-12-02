<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/23/13
 * Time: 1:35 PM
 * To change this template use File | Settings | File Templates.
 */
class Teacher_token_model extends CI_Model{

    public function save($teacher, $ttl, $token_string, $type){
        $token = PropTeacherTokenQuery::create()->filterByType($type)->findOneByToken($token_string);
        if(empty($token) === true){
            $token = new PropTeacherToken();
            $token->setToken($token_string);
            $token->setType($type);
        }

        $teacher_id = PropTeacherQuery::create()->findOneByUserId($teacher->getId());

        $token->setTeacherId($teacher_id->getTeacherId());
        $token->setTtl($ttl);
        $token->save();
        return $token;
    }

    public function get_by_type($token,$type){
        return PropTeacherTokenQuery::create()->filterByType($type)->findOneByToken($token);
    }

    public function destroy($token, $type){
        PropTeacherTokenQuery::create()->filterByToken($token)->filterByType($type)->delete();
    }
}