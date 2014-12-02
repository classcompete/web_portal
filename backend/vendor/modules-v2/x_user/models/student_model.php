<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/4/14
 * Time: 12:30 PM
 */
class Student_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }


    public function save($data, $id = null){
        if(empty($id)){
            $query = new PropStudent();
        }else{
            $query = PropStudentQuery::create()->findOneByStudentId($id);
        }
        if(empty($data->studentId) === false){
            $query->setStudentId($data->studentId);
        }

        if(empty($data->dob) === false){
            $query->setDob($data->dob);
        }
        if(empty($data->gradeId) === false){
            $query->setGradeId($data->gradeId);
        }
        if(empty($data->avatarSettings) === false){
            $query->setAvatarSettings($data->avatarSettings);
        }
        if(empty($data->avatarImage) === false){
            $query->setAvatarImage($data->avatarImage);
        }
        if(empty($data->avatarThumbnail) === false){
            $query->setAvatarThumbnail($data->avatarThumbnail);
        }
        if(empty($data->parentEmail) === false){
            $query->setParentEmail($data->parentEmail);
        }
        if(empty($data->userId) === false){
            $query->setUserId($data->userId);
        }
        if(empty($data->gender) === false){
            $query->setGender($data->gender);
        }


        $query->save();

        return $query;
    }

    public function getStudent($studentId){
        return PropStudentQuery::create()->findOneByStudentId($studentId);
    }
    public function getStudentByUserId($userId){
        return PropStudentQuery::create()->findOneByUserId($userId);
    }

}