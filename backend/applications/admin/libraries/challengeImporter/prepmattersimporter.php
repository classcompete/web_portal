<?php

//require_once APPPATH . 'third_party/PHPExcel/IOFactory.php';
require_once BASEPATH . '../vendor/modules/phpexcel/PHPExcel/IOFactory.php';
error_reporting(E_ALL); ini_set('display_errors', 1);

class PrepmattersImporter
{
    private $ci;
    private $ftpUsername;
    private $ftpPassword;

    public function __construct()
    {
        $ci = &get_instance();
    }

    public function import($importId)
    {
        //get import object
        $import = PropChallengeImportQuery::create()->findOneById($importId);
        $teacher = PropTeacherQuery::create()->findOneByTeacherId($import->getTeacherId());
        $user = PropUserQuery::create()->findOneByUserId($teacher->getUserId());

        if (empty($import) === true){
            throw new PrepmattersImporterException("Unknown import ID");
        }

        $this->ftpUsername = $import->getFtpUsername();
        $this->ftpPassword = $import->getFtpPassword();

        $file = stream_get_contents($import->getFile());

        $filename = tempnam('/tmp', time() . '.xlsx');
        $fp = fopen($filename, 'w');
        fwrite($fp, base64_decode($file));
        fclose($fp);

        $reader = PHPExcel_IOFactory::load($filename);
        $sheetCount = $reader->getSheetCount();
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

        $lastQuestion = null;
        //loop through other tabs and fetch questions
        for ($i=1;$i<$sheetCount;$i++) {
            $questionSheet = $sheets[$i]->toArray();
            foreach ($questionSheet as $row) {
                $subjectCell = $row[0];
                $topicCell = $row[1];
                $subTopicCell = $row[2];
                $typeCell = $row[3];
                $questionCell = $row[4];

                if (in_array($subTopicCell, array('Definitions','Components and Definitions')) === true) {
                    //we will shift topic and subtopic for 2 cases
                    $topicCell = 'Definitions';
                    $subTopicCell = $topicCell;
                }

                $challengeName = sprintf('%s / %s / %s',
                    $subjectCell,
                    $topicCell,
                    $subTopicCell);

                if (isset($challenges[$challengeName]) === false) {
                    $challenges[$challengeName]->questions = array();
                }
                if ($lastQuestion !== $questionCell) {
                    //looks like new question
                    $lastQuestion = $questionCell;
                    $singleQuestion = new stdClass();
                    $singleQuestion->text = $questionCell;
                    $singleQuestion->type = $typeCell;

                    switch($typeCell) {
                        case 'Standard 4 option Multiple Choice':
                            $correctAnswer = trim($row[5]);
                            $answers = array(
                                trim($row[5]),
                                trim($row[6]),
                                trim($row[7]),
                                trim($row[8]),
                            );
                            break;
                        case 'Numerical Entry':
                            $correctAnswer = trim($row[5]);
                            $answers = array();
                            break;
                        case 'True False':
                            if ($row[5] === 'T') {
                                $correctAnswer = 'true';
                                $answers = array('true', 'false');
                            } else {
                                $correctAnswer = 'false';
                                $answers = array('false', 'true');
                            }
                            break;
                        case 'Standard 4 option Multiple Choice Image Question':
                            $questionImage = $this->getImageBase64FromFtp($row[5]);
                            $correctAnswer = $this->getImageBase64FromFtp($row[6]);
                            $answers = array(
                                $this->getImageBase64FromFtp($row[6]),
                                $this->getImageBase64FromFtp($row[7]),
                                $this->getImageBase64FromFtp($row[8]),
                                $this->getImageBase64FromFtp($row[9]),
                            );
                            break;
                        case 'Standard 4 option Multiple Choice Image Answers':
                            $correctAnswer = $this->getImageBase64FromFtp($row[5]);
                            $answers = array(
                                $this->getImageBase64FromFtp($row[5]),
                                $this->getImageBase64FromFtp($row[6]),
                                $this->getImageBase64FromFtp($row[7]),
                                $this->getImageBase64FromFtp($row[8]),
                            );
                            break;
                        case 'Standard 4 option Multiple Choice Image Question Image Answers':
                            $questionImage = $this->getImageBase64FromFtp($row[5]);
                            $correctAnswer = $this->getImageBase64FromFtp($row[6]);
                            $answers = array(
                                $this->getImageBase64FromFtp($row[6]),
                                $this->getImageBase64FromFtp($row[7]),
                                $this->getImageBase64FromFtp($row[8]),
                                $this->getImageBase64FromFtp($row[9]),
                            );
                            break;
                        case 'Standard 2 option Multiple Choice':
                            $correctAnswer = trim($row[5]);
                            $answers = array(
                                trim($row[5]),
                                trim($row[6]),
                            );
                            break;
                        case 'Standard 4 option Multiple Choice':
                            $correctAnswer = trim($row[5]);
                            $answers = array(
                                trim($row[5]),
                                trim($row[6]),
                                trim($row[7]),
                                trim($row[8]),
                            );
                            break;
                        default:
                            $questionImage = null;
                            $correctAnswer = null;
                            $answers = array();
                    }

                    $singleQuestion->questionImage = $questionImage;
                    $singleQuestion->answers = $answers;
                    $singleQuestion->correctAnswer = $correctAnswer;
                    $challenges[$challengeName]->questions[] = $singleQuestion;
                }
            }
        }

        return $challenges;

    }

    private function getImageBase64FromFtp($path)
    {
        $path = str_replace('ftp://', 'ftp://' . $this->ftpUsername . ':' . $this->ftpPassword . '@', $path);
        if (strpos($path, 'http://') === 0 || strpos($path, 'ftp://') === 0) {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $path,
                CURLOPT_TIMEOUT => 3,
            ));
            $content = curl_exec($ch);
            curl_close($ch);
            if (empty($content) === true) {
                return null;
            } else {
                return base64_encode($content);
            }
        } else {
            return $path;
        }

    }
}

class PrepmattersImporterException extends Exception{}