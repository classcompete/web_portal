<?php

/**
 * Teacher panel: import students from spreadsheet files
 */

class Student_import extends MY_Controller {

    public function __construct() {
        parent::__construct();
	    $this->load->library('x_grade/gradelib');
	    $this->load->library('x_users/studentlib');
	    $this->load->library('x_users/studentimportlib');
	    $this->load->library('x_class/classlib');
	    $this->load->library('x_class_student/class_studentlib');
    }

	/**
	 * Show page with the list of uploaded files for importing students
	 */
    public function index() {
	    $data = new stdClass();
	    $this->student_import_model->setOrderBy(PropStudentImportPeer::ID);
	    $this->student_import_model->setOrderByDirection(Criteria::DESC);
	    $data->imports = $this->student_import_model->getList();

        $data->content = $this->load->view('student_import/home', $data, true);
	    $this->load->view(config_item('teacher_template'), $data);
    }

	/**
	 * Save student import record and file for import in db
	 */
    public function save() {
        $importDesc = $this->input->post('stud_import_desc');
	    $importClassId = $this->input->post('stud_import_class_id');

        if ($_FILES['stud_import_file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['stud_import_file']['tmp_name'])) {
	        $filename = $_FILES['stud_import_file']['name'];
            $file = base64_encode(file_get_contents($_FILES['stud_import_file']['tmp_name']));
        }
        else {
	        $filename = '';
	        $file = '';
        }

	    if ($filename) {
		    $teacherId = TeacherHelper::getId();
			$fileExt = strtolower(substr(strrchr($filename, '.'), 1));

		    //Create student import record
		    $data = new stdClass();
		    $data->name = $importDesc;
		    $data->file_ext = $fileExt;
		    $data->file = $file;
		    $data->teacher_id = $teacherId;
		    if ($importClassId) { $data->class_id = $importClassId; }
		    $studentImport = $this->student_import_model->save($data);

            $importId = $studentImport->getId();
            $this->do_import($importId, true);

            $studentImport = PropStudentImportQuery::create()->findOneById($importId);
            if ($studentImport->getStatus() === PropStudentImportPeer::STATUS_FAILED) {
                redirect('classes/?failure=' . base64_encode($studentImport->getResultLog()));
            } else if ($studentImport->getStatus() === PropStudentImportPeer::STATUS_IMPORTED) {
                redirect('classes/?success=' . base64_encode($studentImport->getResultLog()));
            }
	    }
    }

    public function delete_for_import($importId)
    {
        // find all imported students
        $students = PropStudentQuery::create()->filterByImportId($importId)->find();
        $userIds = array();
        $studentIds = array();
        foreach ($students as $student) {
            $userIds[] = $student->getUserId();
            $studentIds[] = $student->getStudentId();
        }

        PropStudentTokenQuery::create()->filterByStudentId($studentIds, Criteria::IN)->delete();
        PropClass_studentQuery::create()->filterByStudentId($studentIds, Criteria::IN)->delete();
        PropStudentQuery::create()->filterByImportId($importId)->delete();
        PropUserQuery::create()->filterByUserId($userIds, Criteria::IN)->delete();

        PropStudentImportQuery::create()->filterById($importId)->delete();
    }

	/**
	 * Do actuall importing of students from uploaded spreadsheet file
	 * @param $importId
	 */
    public function do_import($importId, $return = false) {
        $students = $this->studentimportlib->import_smart($importId);

        // get default male student data for updating student table
        $defaultMaleStudent = $this->studentlib->getDefaultMaleStudentData();
        // get default male student data for updating student table
        $defaultFemaleStudent = $this->studentlib->getDefaultFemaleStudentData();

        foreach ($students as $s) {
	        $studentData = new stdClass();
	        $studentData->first_name = $s->firstName;
	        $studentData->last_name = $s->lastName;
	        $studentData->grade_id = $s->gradeId;
	        $studentData->gender = $s->gender;
	        $studentData->username = $s->username;
	        $studentData->password = $this->studentlib->encodePassword($s->password);
	        $studentData->import_id = $s->importId;

            if($studentData->gender === PropStudentPeer::GENDER_MALE){
                $studentData->avatar_settings = $defaultMaleStudent->getAvatarSettings();
                $studentData->avatar_image = $defaultMaleStudent->getAvatarImage();
                $studentData->avatar_thumbnail = $defaultMaleStudent->getAvatarThumbnail();
            }else{
                $studentData->avatar_settings = $defaultFemaleStudent->getAvatarSettings();
                $studentData->avatar_image = $defaultFemaleStudent->getAvatarImage();
                $studentData->avatar_thumbnail = $defaultFemaleStudent->getAvatarThumbnail();
            }

	        $userObj = $this->student_model->save($studentData);
	            //Doesn't work! Propel won't return student id emidietly after save, for unknown reason...
	        //$studentObj = $this->student_model->save($studentData, null, TRUE); //Return result as PropStudent object

	        $classStudData = new stdClass();
	        $classStudData->class_id = $s->classId;
	        $classStudData->user_id = $userObj->getUserId();
	        //$classStudData->student_id = $studentObj->getStudentId();
	        $this->class_student_model->save($classStudData);
        }

        if ($return === false) {
            redirect('student_import');
        } else {
            return $importId;
        }

    }

	/**
	 * Delete student import record
	 * @param $id
	 * @throws Exception
	 * @throws PropelException
	 */
    public function delete($id) {
	    $this->student_import_model->deleteById($id);
        redirect('student_import');
    }
}