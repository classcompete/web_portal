<?php

class Challenge_import extends MY_Controller
{

    public function index()
    {
        $teachers = PropTeacherQuery::create()
            ->filterByPublisher(PropTeacherPeer::PUBLISHER_PUBLIC)
            ->innerJoinPropUser()
            ->find();

        $data = new stdClass();
        $data->teachers = $teachers;
        $data->importers = array(
            'prepmatters' => 'PrepMatters',
        );
        $data->imports = PropChallengeImportQuery::create()->orderById(Criteria::DESC)->find();

        $data->content = $this->load->view('challenge_import/index', $data, true);
        $this->load->view('compete', $data);
    }

    public function save()
    {
        $name = $this->input->post('name');
        $teacherId = $this->input->post('teacher_id');
        $importer = $this->input->post('importer');
        $ftpUsername = $this->input->post('ftp_username');
        $ftpPassword = $this->input->post('ftp_password');

        if (empty($ftpUsername) === false) {
            $useFtp = PropChallengeImportPeer::USE_FTP_YES;
        } else {
            $useFtp = PropChallengeImportPeer::USE_FTP_NO;
        }

        if ($_FILES['file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file']['tmp_name'])) {
            $file = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
        } else {
            $file = '';
        }

        //create import record
        $import = new PropChallengeImport();
        $import->setTeacherId($teacherId);
        $import->setName($name);
        $import->setImporter($importer);
        $import->setUseFtp($useFtp);
        $import->setFtpUsername($ftpUsername);
        $import->setFtpPassword($ftpPassword);
        $import->setFile($file);
        $import->save();

        redirect('challenge_import');
    }

    public function doImport($importId)
    {
        $this->load->library('challengeImporter/PrepmattersImporter', null, 'importer');
        $challenges = $this->importer->import($importId);

        foreach ($challenges as $c)
        {
            if (isset($c->questions) === true && empty($c->questions) === false &&(
                    $c->subjectId > 0 && $c->topicId > 0 && $c->subTopicId > 0 && $c->gameId > 0 && $c->userId > 0
                )) {
                // questions are set and not empty

                // create a challenge
                $challenge = new PropChallenge();
                $challenge->setName($c->name);
                $challenge->setSubjectId($c->subjectId);
                $challenge->setSkillId($c->topicId);
                $challenge->setTopicId($c->subTopicId);
                $challenge->setLevel($c->level);
                $challenge->setGameId($c->gameId);
                $challenge->setGameLevelId($c->gameLevelId);
                $challenge->setUserId($c->userId);
                $challenge->setDescription($c->description);
                $challenge->setIsPublic($c->isPublic);
                $challenge->setImportId($importId);
                $challenge->save();

                $challengeId = $challenge->getId();
                if (intval($challengeId) > 0) {
                    // this will prove that it is valid challenge ID

                    // loop questions and add them
                    foreach ($c->questions as $q) {

                        if ($q->type === 'Numerical Entry') {
                            $type = 'calculator';
                        } else {
                            $type = 'multiple_choice';
                        }

                        $question = new PropQuestion();
                        $question->setSubjectId($challenge->getSubjectId());
                        $question->setSkillId($challenge->getSkillId());
                        $question->setTopicId($challenge->getTopicId());
                        $question->setLevel($challenge->getLevel());
                        $question->setType($type);
                        $question->setText($q->text);
                        $question->setImage($q->questionImage);
                        $question->setCorrectText($q->correctAnswer);
                        $question->setImportId($importId);
                        $question->save();

                        $questionId = $question->getId();

                        // passes counter to see when to assign question to challenge (after last one has been added)
                        $choicePasses = 0;
                        if (intval($questionId) > 0) {
                            // this will prove that question was saved properly
                            if (empty($q->answers) === false) {
                                // there are answers defined
                                foreach ($q->answers as $aKey => $a) {
                                    $questionChoice = new PropQuestionChoice();
                                    $questionChoice->setQuestionId($questionId);
                                    if (strlen($a) > 100) {
                                        //looks like an image
                                        $questionChoice->setImage($a);
                                    } else {
                                        $questionChoice->setText($a);
                                    }
                                    $questionChoice->setImportId($importId);
                                    $questionChoice->save();
                                    $questionChoiceId = $questionChoice->getChoiceId();
                                    if ($aKey === 0) {
                                        // if on first position it should be correct answer and we need to update question
                                        $question->setCorrectChoiceId($questionChoiceId);
                                        $question->save();
                                    }
                                    $choicePasses++;
                                }
                                if ($choicePasses === count($q->answers)) {
                                    $cqRel = new PropChallengeQuestion();
                                    $cqRel->setChallengeId($challengeId);
                                    $cqRel->setQuestionId($questionId);
                                    $cqRel->setImportId($importId);
                                    $cqRel->save();
                                }
                            } elseif ($type === 'calculator') {
                                // if calculator we will have no answers to add - just make relation
                                $cqRel = new PropChallengeQuestion();
                                $cqRel->setChallengeId($challengeId);
                                $cqRel->setQuestionId($questionId);
                                $cqRel->setImportId($importId);
                                $cqRel->save();
                            }
                        }
                    }
                }
            }
        }

        redirect('challenge_import');
    }

    public function delete($id)
    {
        PropChallengeImportQuery::create()->filterById($id)->delete();
        redirect('challenge_import');
    }

    public function rollback($importId)
    {
        //delete question choices
        PropQuestionChoiceQuery::create()->filterByImportId($importId)->delete();
        //delete challenge questions relations
        PropChallengeQuestionQuery::create()->filterByImportId($importId)->delete();
        //delete questions
        PropQuestionQuery::create()->filterByImportId($importId)->delete();
        //delete challenges
        PropChallengeQuery::create()->filterByImportId($importId)->delete();
    }
}