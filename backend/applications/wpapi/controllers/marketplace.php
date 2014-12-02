<?php

class Marketplace extends MY_Controller
{

    public function __construct()
    {
        $this->load->model('x_challenge/challenge_model');
        $this->load->model('x_users/teacher_model');
    }

    /** gets all challenges. if is set '?grade=2' it will show challenges only for 2nd grade */
    public function index()
    {
        $filters = $this->input->get();

        $single_grade = false;

        $result = array();
        if (isset($filters['grade']) === true && empty($filters['grade']) === false) {
            $this->challenge_model->filterByLevel($filters['grade']);
            $single_grade = true;
            $out = array();
        } else {
            $out['grade']['1'] = array();
            $out['grade']['2'] = array();
            $out['grade']['3'] = array();
            $out['grade']['4'] = array();
            $out['grade']['5'] = array();
            $out['grade']['6'] = array();
            $out['grade']['7'] = array();
            $out['grade']['8'] = array();
        }

        $list = $this->challenge_model->getList();

        foreach ($list as $k => $v) {
            /** @var $v PropChallenge */
            $grade = $v->getLevel();

            $result[$k]['challenge_name'] = $v->getName();
            $result[$k]['grade'] = $grade;
            $result[$k]['author'] = $this->challenge_model->get_teacher_name($v->getUserId());
            $result[$k]['subject'] = $v->getPropSubjects()->getName();
            $result[$k]['topic'] = $v->getPropSkills()->getName();
            if (intval($v->getTopicId()) > 0) {
                $result[$k]['subtopic'] = $v->getPropTopic()->getName();
            } else {
                $result[$k]['subtopic'] = null;
            }

            $result[$k]['environment'] = $v->getPropGames()->getName();
            $result[$k]['description'] = $v->getDescription();
            $avatar = $this->teacher_model->get_teacher_image($v->getUserId());
            $result[$k]['avatar'] = $avatar['image_thumb'];

            $out['grade'][$grade][] = $result[$k];
        }

        if ($single_grade === true) {
            if (empty($out) === false) {
                $out = $out['grade'][$filters['grade']];
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($out));
    }

    /** gets single challenge by id */
    public function single($id)
    {
        $this->challenge_model->setSingleChallenge($id);
        $challenge = $this->challenge_model->getList()->getFirst();

        $result = new stdClass();
        if (empty($challenge) === false) {
            $result->challenge_name = $challenge->getName();
            $result->grade = $challenge->getLevel();
            $result->author = $this->challenge_model->get_teacher_name($challenge->getUserId());
            $result->subject = $challenge->getPropSubjects()->getName();
            $result->topic = $challenge->getPropSkills()->getName();
            $result->subtopic = $challenge->getPropTopic()->getName();
            $result->environment = $challenge->getPropGames()->getName();
            $result->description = $challenge->getDescription();
            $avatar = $this->teacher_model->get_teacher_image($challenge->getUserId());
            $result->avatar = $avatar['image_thumb'];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}