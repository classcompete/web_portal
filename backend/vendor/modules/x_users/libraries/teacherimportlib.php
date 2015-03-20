<?php

require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';
error_reporting(E_ALL); ini_set('display_errors', 1);

class Teacherimportlib {
    private $ci;

    public function __construct() {
        $this->ci = &get_instance();
	    //$this->ci->load->model('x_users/users_model');
	    $this->ci->load->library('x_users/userslib');
        $this->ci->load->model('x_users/teacher_model');
        $this->ci->load->model('x_users/teacher_token_model');
	    $this->ci->load->model('x_users/teacher_import_model');
	    $this->ci->load->library('x_users/teacherlib');
        $this->ci->load->helper('x_users/teacher');
    }

    public function import($importId) {
            //Get teacher import object
        $import = PropTeacherImportQuery::create()->findOneById($importId);

        if (empty($import) === true) { throw new TeacherImportException("Unknown import ID"); }

        $file = stream_get_contents($import->getFile());
        $filename = tempnam('/tmp', time() . '.csv');
        $fp = fopen($filename, 'w');
        fwrite($fp, base64_decode($file));
        fclose($fp);

	    $error = FALSE;
	    $teachers = array();
	    $totalRows = 0;
		$fp = fopen($filename, "r");
		while(! feof($fp)) {
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
						$singleTeacher->username = $this->ci->userslib->generateUniqueUsername($rowArr[0] . ' ' . $rowArr[1]);
						$singleTeacher->importId = $importId;
						$teachers[] = $singleTeacher;
					}
					else {
						$error = TRUE;
						//TODO: What to do if teacher email is already in db? Log it somewhere?
					}
				}
				else { $error = TRUE; }
			}
		}
		fclose($fp);
		if (! $totalRows) { $error = TRUE; }

	    $importData = new stdClass();
	        //TODO: Status not written correctly...
	    //$importData->status = $error ? PropTeacherImportPeer::STATUS_ERROR : PropTeacherImportPeer::STATUS_SUCCESS;
	    $importData->status = PropTeacherImportPeer::STATUS_SUCCESS;
	    $this->ci->teacher_import_model->save($importData, $importId);

	    return $teachers;

	    /*
        $reader = PHPExcel_IOFactory::load($filename);
        $sheets = $reader->getAllSheets();

        $challenges = array();
        $challengesSheet = $sheets[0]->toArray();
        foreach ($challengesSheet as $row) {
            $subjectCell = $row[0];
            $topicCell = $row[1];
            $subTopicCell = $row[2];

            $subject = PropSubjectsQuery::create()->filterByName($subjectCell, Criteria::LIKE)->findOne();
            if (empty($subject) === false) {
                if (in_array($subTopicCell, array('Definitions','Components and Definitions')) === true) {
                    //we will shift topic and subtopic for 2 cases
                    $topic = PropSkillsQuery::create()->filterByName('Definitions', Criteria::LIKE)->findOne();
                    $subTopic = PropTopicQuery::create()->filterByName($topicCell, Criteria::LIKE)->findOne();
                } else {
                    $topic = PropSkillsQuery::create()->filterByName($topicCell, Criteria::LIKE)->findOne();
                    $subTopic = PropTopicQuery::create()->filterByName($subTopicCell, Criteria::LIKE)->findOne();
                }

                if (empty($topic) === true) {
                    throw new PrepmattersImporterException("Unknown Skill $topicCell");
                }
                if (empty($subTopic) === true) {
                    throw new PrepmattersImporterException("Unknown Topic $subTopicCell");
                }

                $singleChallenge = new stdClass();
                $singleChallenge->name = sprintf('%s / %s / %s',
                    $subject->getName(),
                    $topic->getName(),
                    $subTopic->getName());
                $singleChallenge->desc = 'Auto-generated challenge for import ' . $import->getName() . PHP_EOL . $singleChallenge->name;
                $singleChallenge->subjectId = $subject->getSubjectId();
                $singleChallenge->topicId = $topic->getSkillId();
                $singleChallenge->subTopicId = $subTopic->getTopicId();
                $singleChallenge->teacherId = $import->getTeacherId();
                $singleChallenge->level = 0; //set by default - but should be something else
                $singleChallenge->gameId = 6; //set by default - Brain Runner
                $singleChallenge->gameLevelId = 0;
                $singleChallenge->userId = $user->getUserId();
                $singleChallenge->description = $singleChallenge->desc;
                $singleChallenge->isPublic = 0; //this challenges are not public by default

                $challenges[$singleChallenge->name] = $singleChallenge;
            }
        }

        return $challenges;
	    */
    }
}

class TeacherImportException extends Exception{}