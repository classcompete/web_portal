<?php

//require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';
require_once BASEPATH . '../vendor/modules/phpexcel/PHPExcel/IOFactory.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Studentimportlib
{
    private $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    /**
     * Import students from any supported file type - infer which method to use by filename extension
     * @param $importId
     * @throws StudentImportException
     */
    public function import_smart($importId)
    {
        //Get student import record
        $import = PropStudentImportQuery::create()->findOneById($importId);
        if (empty($import) === true) {
            throw new StudentImportException("Unknown import ID");
        }
        $ext = $import->getFileExt();
        if ($ext == 'csv') {
            return $this->import_csv($importId);
        } else if (($ext == 'xls') || ($ext == 'xlsx')) {
            return $this->import_xls($importId);
        }
    }

    /**
     * Import students from XLS and XLSX (Excel) file
     * @param $importId
     * @return array
     * @throws StudentImportException
     */
    public function import_xls($importId)
    {
        //Get student import record
        $importObj = PropStudentImportQuery::create()->findOneById($importId);
        if (empty($importObj) === true) {
            throw new StudentImportException("Unknown import ID");
        }

        //Get class record and determinate limit number of imported students
        $checkStudLimit = FALSE;
        $newStudLimit = 0;
        if ($importObj->getClassId()) {
            $classObj = PropClasQuery::create()->findOneByClassId($importObj->getClassId());
            if (empty($classObj) === true) {
                throw new StudentImportException("Unknown class ID");
            }
            $checkStudLimit = TRUE;
            $newStudLimit = $classObj->getLimit() - $this->ci->class_student_model->count_students_in_class($classObj->getClassId());
        }
        //throw new StudentImportException("newStudLimit: " . $newStudLimit);

        $file = stream_get_contents($importObj->getFile());
        $filename = tempnam('/tmp', time() . '.xlsx');
        $fp = fopen($filename, 'w');
        fwrite($fp, base64_decode($file));
        fclose($fp);

        //1. Import data from XLS file
        $errors = array();
        $students = array();
        $totalRows = 0;
        $importedRows = 0;
        try {
            $reader = PHPExcel_IOFactory::load($filename);
            //$sheetCount = $reader->getSheetCount();
            $sheets = $reader->getAllSheets();

            $studentsSheet = $sheets[0]->toArray();
            foreach ($studentsSheet as $rowArr) {
                if ($totalRows++) {
                    if ($checkStudLimit && ($importedRows >= $newStudLimit)) {
                        $errors[] = '* Reached limit of ' . $classObj->getLimit() . ' students in class ' . $classObj->getName(); // . ', at row ' . $totalRows;
                        break;
                    }

                    $impFirstName = trim($rowArr[0]);
                    $impLastName = trim($rowArr[1]);
                    $impGrade = trim($rowArr[2]);
                    $impGender = trim($rowArr[3]);
                    $impUsername = trim($rowArr[4]);
                    $impPassword = trim($rowArr[5]);

                    if ($impFirstName && $impLastName && $impGrade && $impGender && $impUsername && $impPassword) {
                        $impGradeId = 0;
                        $is_unique = $this->ci->users_model->is_unique_username($impUsername);
                        //if (! $is_unique) {
                        //	$impUsername = $this->ci->userslib->generateUniqueUsername($impFirstName . ' ' . $impLastName);
                        //  $is_unique = TRUE;
                        //}
                        $grade_ok = in_array(strtolower($impGrade), array('pre k', 'k', '1', '2', '3', '4', '5', '6', '7', '8'));
                        if ($grade_ok) {
                            //Find grade ID
                            $tmpGrade = strtolower($impGrade);
                            if (($tmpGrade != 'pre k') && ($tmpGrade != 'k')) {
                                $tmpGrade = 'grade ' . $tmpGrade;
                            }
                            $gradeObj = $this->ci->grade_model->getGradeByName($tmpGrade);
                            if ($gradeObj) {
                                $impGradeId = $gradeObj->getId();
                            } else {
                                $grade_ok = FALSE;
                            }
                        }
                        $gender_ok = (strtolower($impGender) == 'male') || (strtolower($impGender) == 'female')
                                        || (strtolower($impGender) == 'm') || (strtolower($impGender) == 'f');
                        $pass_ok = strlen($impPassword) >= 6;

                        if (!$is_unique) {
                            $errors[] = '* Username "' . $impUsername . '" in row ' . $totalRows . ' is already used by another registered user';
                        } else if (!$grade_ok) {
                            $errors[] = '* Invalid grade value "' . $impGrade . '" in row ' . $totalRows;
                        } else if (!$gender_ok) {
                            $errors[] = '* Invalid gender value "' . $impGender . '" in row ' . $totalRows;
                        } else if (!$pass_ok) {
                            $errors[] = '* Password "' . $impPassword . '" is too short in row ' . $totalRows;
                        } else {
                            //When importing students, there is no email data - beacuse of the legal implications...
                            $singleStudent = new stdClass();
                            $singleStudent->firstName = $impFirstName;
                            $singleStudent->lastName = $impLastName;
                            $singleStudent->gradeId = $impGradeId;
                            $singleStudent->gender = (strtolower($impGender) == 'male' || strtolower($impGender) == 'm') ? PropStudentPeer::GENDER_MALE : PropStudentPeer::GENDER_FEMALE;
                            $singleStudent->username = $impUsername;
                            $singleStudent->password = $impPassword;
                            $singleStudent->importId = $importId;
                            $singleStudent->classId = $importObj->getClassId();
                            $students[] = $singleStudent;
                            $importedRows++;
                        }
                    } else {
                        if (!$impFirstName) {
                            $errors[] = '* No first name data in row ' . $totalRows;
                        } else if (!$impLastName) {
                            $errors[] = '* No last name data in row ' . $totalRows;
                        } else if (!$impGrade) {
                            $errors[] = '* No grade data in row ' . $totalRows;
                        } else if (!$impGender) {
                            $errors[] = '* No gender data in row ' . $totalRows;
                        } else if (!$impUsername) {
                            $errors[] = '* No username data in row ' . $totalRows;
                        } else if (!$impPassword) {
                            $errors[] = '* No password data in row ' . $totalRows;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $errors[] = '* Exception: ' . $e->getMessage();
        }

        //2. Update student import record
        $importData = new stdClass();
        $importData->status = (!empty($errors)) ? PropStudentImportPeer::STATUS_FAILED : PropStudentImportPeer::STATUS_IMPORTED;
        $resultLog = '';
        if (!empty($errors)) {
            foreach ($errors as $error) {
                if ($resultLog) {
                    $resultLog .= "\n" . $error;
                } else {
                    $resultLog .= $error;
                }
            }
        }
        if ($totalRows) {
            if ($resultLog) {
                $resultLog .= "\n";
            }
            $resultLog .= '* Total students imported: ' . $importedRows;
        }

        $importData->result_log = $resultLog;
        $this->ci->student_import_model->save($importData, $importId);

        return $students;
    }

    /**
     * Import students from CSV file
     * @param $importId
     * @return array
     * @throws StudentImportException
     */
    public function import_csv($importId)
    {
        //Get student import record
        $importObj = PropStudentImportQuery::create()->findOneById($importId);
        if (empty($importObj) === true) {
            throw new StudentImportException("Unknown import ID");
        }

        //Get class record and determinate limit number of imported students
        $checkStudLimit = FALSE;
        $newStudLimit = 0;
        if ($importObj->getClassId()) {
            $classObj = PropClasQuery::create()->findOneByClassId($importObj->getClassId());
            if (empty($classObj) === true) {
                throw new StudentImportException("Unknown class ID");
            }
            $checkStudLimit = TRUE;
            $newStudLimit = $classObj->getLimit() - $this->ci->class_student_model->count_students_in_class($classObj->getClassId());
        }

        $file = stream_get_contents($importObj->getFile());
        $filename = tempnam('/tmp', time() . '.csv');
        $fp = fopen($filename, 'w');
        fwrite($fp, base64_decode($file));
        fclose($fp);

        //1. Import data from CSV file
        //0: First name, 1: Last name, 2: Grade, 3: Gender, 4: Username, 5: Password
        $errors = array();
        $students = array();
        $totalRows = 0;
        $importedRows = 0;
        try {
            $fp = fopen($filename, "r");
            while (!feof($fp)) {
                $rowArr = fgetcsv($fp);
                if ($totalRows++) {
                    if ($checkStudLimit && ($importedRows >= $newStudLimit)) {
                        $errors[] = '* Reached limit of ' . $classObj->getLimit() . ' students in class ' . $classObj->getName(); // . ', at row ' . $totalRows;
                        break;
                    }

                    if ($rowArr[0] !== NULL) {
                        $impFirstName = trim($rowArr[0]);
                        $impLastName = trim($rowArr[1]);
                        $impGrade = trim($rowArr[2]);
                        $impGender = trim($rowArr[3]);
                        $impUsername = trim($rowArr[4]);
                        $impPassword = trim($rowArr[5]);
                    } else {
                        $impFirstName = '';
                        $impLastName = '';
                        $impGrade = '';
                        $impGender = '';
                        $impUsername = '';
                        $impPassword = '';
                    }

                    if ($impFirstName && $impLastName && $impGrade && $impGender && $impUsername && $impPassword) {
                        $impGradeId = 0;
                        $is_unique = $this->ci->users_model->is_unique_username($impUsername);
                        //if (! $is_unique) {
                        //	$impUsername = $this->ci->userslib->generateUniqueUsername($impFirstName . ' ' . $impLastName);
                        //  $is_unique = TRUE;
                        //}
                        $grade_ok = in_array(strtolower($impGrade), array('pre k', 'k', '1', '2', '3', '4', '5', '6', '7', '8'));
                        if ($grade_ok) {
                            //Find grade ID
                            $tmpGrade = strtolower($impGrade);
                            if (($tmpGrade != 'pre k') && ($tmpGrade != 'k')) {
                                $tmpGrade = 'grade ' . $tmpGrade;
                            }
                            $gradeObj = $this->ci->grade_model->getGradeByName($tmpGrade);
                            if ($gradeObj) {
                                $impGradeId = $gradeObj->getId();
                            } else {
                                $grade_ok = FALSE;
                            }
                        }
                        $gender_ok = (strtolower($impGender) == 'male') || (strtolower($impGender) == 'female');
                        $pass_ok = strlen($impPassword) >= 6;

                        if (!$is_unique) {
                            $errors[] = '* Username "' . $impUsername . '" in row ' . $totalRows . ' is already used by another registered user';
                        } else if (!$grade_ok) {
                            $errors[] = '* Invalid grade value "' . $impGrade . '" in row ' . $totalRows;
                        } else if (!$gender_ok) {
                            $errors[] = '* Invalid gender value "' . $impGender . '" in row ' . $totalRows;
                        } else if (!$pass_ok) {
                            $errors[] = '* Password "' . $impPassword . '" is too short in row ' . $totalRows;
                        } else {
                            //When importing students, there is no email data - beacuse of the legal implications...
                            $singleStudent = new stdClass();
                            $singleStudent->firstName = $impFirstName;
                            $singleStudent->lastName = $impLastName;
                            $singleStudent->gradeId = $impGradeId;
                            $singleStudent->gender = (strtolower($impGender) == 'male') ? PropStudentPeer::GENDER_MALE : PropStudentPeer::GENDER_FEMALE;
                            $singleStudent->username = $impUsername;
                            $singleStudent->password = $impPassword;
                            $singleStudent->importId = $importId;
                            $singleStudent->classId = $importObj->getClassId();
                            $students[] = $singleStudent;
                            $importedRows++;
                        }
                    } else {
                        if ($rowArr[0] === NULL) {
                            //Blank line - do nothing, it's not error
                        } else if (!$impFirstName) {
                            $errors[] = '* No first name data in row ' . $totalRows;
                        } else if (!$impLastName) {
                            $errors[] = '* No last name data in row ' . $totalRows;
                        } else if (!$impGrade) {
                            $errors[] = '* No grade data in row ' . $totalRows;
                        } else if (!$impGender) {
                            $errors[] = '* No gender data in row ' . $totalRows;
                        } else if (!$impUsername) {
                            $errors[] = '* No username data in row ' . $totalRows;
                        } else if (!$impPassword) {
                            $errors[] = '* No password data in row ' . $totalRows;
                        }
                    }
                }
            }
            fclose($fp);
            if (!$importedRows) {
                $errors[] = '* There is no data in the file to import.';
            }
        } catch (Exception $e) {
            $errors[] = '* Exception: ' . $e->getMessage();
        }

        //2. Update student import record
        $importData = new stdClass();
        $importData->status = (!empty($errors)) ? PropStudentImportPeer::STATUS_FAILED : PropStudentImportPeer::STATUS_IMPORTED;
        $resultLog = '';
        if (!empty($errors)) {
            foreach ($errors as $error) {
                if ($resultLog) {
                    $resultLog .= "\n" . $error;
                } else {
                    $resultLog .= $error;
                }
            }
        }
        if ($totalRows) {
            if ($resultLog) {
                $resultLog .= "\n";
            }
            $resultLog .= '* Total students imported: ' . $importedRows;
        }

        $importData->result_log = $resultLog;
        $this->ci->student_import_model->save($importData, $importId);

        return $students;
    }
}

class StudentImportException extends Exception
{
}