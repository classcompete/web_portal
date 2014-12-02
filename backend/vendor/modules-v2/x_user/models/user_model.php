<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/1/14
 * Time: 3:24 PM
 */
class User_model extends CI_Model{

    public function __construct(){
        parent:: __construct();
    }

    public function save($data, $id = null){
        if(empty($id)){
            $user = new PropUser();
        }else{
            $user = PropUserQuery::create()->findOneByUserId($id);
        }
        if(empty($data->username) === false){
            $user->setLogin($data->username);
        }
        if(empty($data->password) === false){
            $user->setPassword($data->password);
        }
        if(empty($data->firstName) === false){
            $user->setFirstName($data->firstName);
        }
        if(empty($data->lastName) === false){
            $user->setLastName($data->lastName);
        }
        if(empty($data->email) === false){
            $user->setEmail($data->email);
        }

        $user->save();

        return $user;
    }

    public function getUser($userId){
        return PropUserQuery::create()->findOneByUserId($userId);
    }
    public function getUserByUserName($username){
        return PropUserQuery::create()->findOneByLogin($username);
    }
    public function getUserByEmail($email){
        return PropUserQuery::create()->findOneByEmail($email);
    }
    public function getStudentByUsernamePasswordSql($username, $password){
        $sql = "SELECT * FROM users WHERE login = '".$username ."' AND password = PASSWORD('".$password."')";
        $user = $this->db->query($sql)->row();

        return $user;
    }
}