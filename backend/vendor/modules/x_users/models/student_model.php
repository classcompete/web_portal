<?php
/**
 * Wrapper for Propel model of Students table.
 */

class Student_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

	/**
	 * Save Student record: saving both PropUser and PropStudent objects
	 * @param $data
	 * @param null $id
	 * @return PropUser
	 */
    public function save($data, $id = null){
	        //1. Save User record
        if (empty($id)) { $user = new PropUser(); }
        else {
	        $user = PropUserQuery::create()->findOneByUserId($id);
	        $user->setModified(date("Y-m-d H:i:s")); //Not a Propel "timestampable" field, so we must do it manually
        }

        if (isset($data->username)) { $user->setLogin($data->username); }
        if (isset($data->email)) { $user->setEmail($data->email); }
        if (isset($data->password)) { $user->setPassword($data->password); }
        if (isset($data->first_name)) { $user->setFirstName($data->first_name); }
        if (isset($data->last_name)) { $user->setLastName($data->last_name); }

        $user->save();

	        //2. Save Student record
        if (empty($id)) { $student = new PropStudent(); }
        else {
	        $student = PropStudentQuery::create()->findOneByStudentId($id);
	        $student->setModified(date("Y-m-d H:i:s")); //Not a Propel "timestampable" field, so we must do it manually
        }
		$student->setPropUser($user);

	    if (isset($data->user_id)) { $student->setUserId($data->user_id); }
	    if (isset($data->dob)) { $student->setDob($data->dob); }
	    if (isset($data->grade_id)) { $student->setGradeId($data->grade_id); }
	    if (isset($data->avatar_settings)) { $student->setAvatarSettings($data->avatar_settings); }
	    if (isset($data->avatar_image)) { $student->setAvatarImage($data->avatar_image); }
	    if (isset($data->avatar_thumbnail)) { $student->setAvatarThumbnail($data->avatar_thumbnail); }
	    if (isset($data->parent_email)) { $student->setParentEmail($data->parent_email); }
	    if (isset($data->gender)) { $student->setGender($data->gender); }
	    if (isset($data->import_id)) { $student->setImportId($data->import_id); }

        $student->save();

        return $user;
    }

        //***************************************************
        // SEARCH
        //***************************************************

    public function getStudentById($studentId){
        return PropStudentQuery::create()->findOneByStudentId($studentId);
    }

    public function getStudentByUserId($userId){
        return PropStudentQuery::create()->findOneByUserId($userId);
    }

}