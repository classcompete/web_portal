<?php

//require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';
require_once BASEPATH . '../vendor/modules/phpexcel/PHPExcel/IOFactory.php';
error_reporting(E_ALL); ini_set('display_errors', 1);

class Teacherimportlib {
    private $ci;

    public function __construct() {
        $this->ci = &get_instance();
	    $this->ci->load->library('x_users/userslib');
        $this->ci->load->model('x_users/teacher_model');
        $this->ci->load->model('x_users/teacher_token_model');
	    $this->ci->load->model('x_users/teacher_import_model');
	    $this->ci->load->library('x_users/teacherlib');
        $this->ci->load->helper('x_users/teacher');
    }

    public function import($importId) {
            //Get teacher import record
        $import = PropTeacherImportQuery::create()->findOneById($importId);

        if (empty($import) === true) { throw new TeacherImportException("Unknown import ID"); }

        $file = stream_get_contents($import->getFile());
        $filename = tempnam('/tmp', time() . '.csv');
        $fp = fopen($filename, 'w');
        fwrite($fp, base64_decode($file));
        fclose($fp);

	        //1. Import data from CSV file
	    $errors = array();
	    $teachers = array();
	    $totalRows = 0;
	    $importedRows = 0;
		try {
			$fp = fopen($filename, "r");
			while (!feof($fp)) {
				$rowArr = fgetcsv($fp);
				if ($totalRows++) {
					if ($rowArr[0] && $rowArr[1] && $rowArr[2]) {
						//TODO: Why this is not working? Because there is no username?
						//$is_unique = $this->ci->users_model->is_unique_username_and_email('', $rowArr[2]);
						$is_unique = $this->ci->users_model->is_unique_email($rowArr[2]);
						if ($is_unique) {
							$singleTeacher = new stdClass();
							$singleTeacher->firstName = $rowArr[0];
							$singleTeacher->lastName = $rowArr[1];
							$singleTeacher->email = $rowArr[2];
							//$singleTeacher->username = $this->ci->userslib->generateUniqueUsername($rowArr[0] . ' ' . $rowArr[1]);
								//When importing teachers, username is the same as email
							$singleTeacher->username = $rowArr[2];
							$singleTeacher->importId = $importId;
							$teachers[] = $singleTeacher;
							$importedRows++;
						} else {
							$errors[] = '* Email is already used by registered user: ' . $rowArr[2];
						}
					}
					else {
						if ($rowArr[0] === NULL) {
							//Blank line - do nothing, it's not error
						}
						else if (! $rowArr[0]) {
							$errors[] = '* No first name data in row: ' . $totalRows;
						}
						else if (! $rowArr[1]) {
							$errors[] = '* No last name data in row: ' . $totalRows;
						}
						else if (! $rowArr[2]) {
							$errors[] = '* No email data in row: ' . $totalRows;
						}
					}
				}
			}
			fclose($fp);
			if (! $importedRows) {
				$errors[] = '* There is no data in the file to import.';
			}
		} catch (Exception $e) {
			$errors[] = '* Exception: ' . $e->getMessage();
		}

	        //2. Update teacher import record
	    $importData = new stdClass();
	    $importData->status = (! empty($errors)) ? PropTeacherImportPeer::STATUS_ERROR : PropTeacherImportPeer::STATUS_SUCCESS;
	    $resultLog = '';
	    if (! empty($errors)) {
		    foreach ($errors as $error) {
			    if ($resultLog) { $resultLog .= "\n" . $error; }
			    else { $resultLog .= $error; }
		    }
	    }
	    if ($totalRows) {
		    if ($resultLog) { $resultLog .= "\n"; }
		    $resultLog .= '* Total teachers imported: ' . $importedRows;
	    }

	    $importData->result_log = $resultLog;
	    $this->ci->teacher_import_model->save($importData, $importId);

	    return $teachers;
    }
}

class TeacherImportException extends Exception{}