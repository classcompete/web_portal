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
        $name = $this->input->post('name');

        if ($_FILES['file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file']['tmp_name'])) {
	        $filename = $_FILES['file']['name'];
            $file = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
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
		    $data->name = $name;
		    $data->file_ext = $fileExt;
		    $data->file = $file;
		    $data->teacher_id = $teacherId;
		    $this->student_import_model->save($data);
	    }

        redirect('student_import');
    }

	/**
	 * Do actuall importing of students from uploaded spreadsheet file
	 * @param $importId
	 */
    public function do_import($importId) {
        $students = $this->studentimportlib->import_smart($importId);

	    /*foreach ($students as $s) {
		    echo $s->firstName . ' - ' . $s->lastName . ' - ' . $s->gradeId . ' - ' . $s->gender . ' - ' .
	            $s->username . ' - ' . $s->password .'<br/>';
	    }
		exit;*/

        foreach ($students as $s) {
	        $studentData = new stdClass();
	        $studentData->first_name = $s->firstName;
	        $studentData->last_name = $s->lastName;
	        $studentData->grade_id = $s->gradeId;
	        $studentData->gender = $s->gender;
	        $studentData->username = $s->username;
	        $studentData->password = $this->studentlib->encodePassword($s->password);
	        $studentData->import_id = $s->importId;
	        $this->student_model->save($studentData);
        }

        redirect('student_import');
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