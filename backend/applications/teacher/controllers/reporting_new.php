<?php

class Reporting_new extends MY_Controller
{
    public function __construct()
    {
        parent:: __construct();
    }

    public function index()
    {
        $challengeStatsQ = $this->db->query("SELECT CH.name, COUNT(SC.score_id) AS count_students_played
          FROM class_compete.challenges CH
          JOIN class_compete.scores SC ON CH.challenge_id=SC.challenge_id
          GROUP BY CH.challenge_id
          ORDER BY 2 DESC;")->result();

        $challengeStats = array(array('Name', 'Plays'));
        foreach ($challengeStatsQ as $c) {
            array_push($challengeStats, array(
                $c->name,
                intval($c->count_students_played),
            ));
        }

        $studentsPerChallengeStatsQ = $this->db->query("SELECT CH.name, SC.student_id, COUNT(SC.score_id) AS count_played_by_student
          FROM class_compete.challenges CH
          JOIN class_compete.scores SC
          ON CH.challenge_id=SC.challenge_id
          GROUP BY CH.challenge_id, SC.student_id
          ORDER BY 1, 2, 3 DESC;")->result();

        // make column names from Challenge Names
        $headers = array('Student');
        foreach ($studentsPerChallengeStatsQ as $c) {
            if (in_array($c->name, $headers) === false) {
                $headers[] = $c->name;
            }
        }

        $rows = array();
        foreach ($studentsPerChallengeStatsQ as $c) {
            if (in_array($c->student_id, $rows) === false) {
                $rows[] = $c->student_id;
            }
        }

        $studentsPerChallengeStats = array($headers);
        foreach ($rows as $id) {
            foreach ($headers as $h) {
                $studentsPerChallengeStats[$id][] = 0;
            }
        }


        foreach ($studentsPerChallengeStatsQ as $c) {
            // get key position of element in columns on name
            $k = array_search($c->name, $headers);
            $studentsPerChallengeStats[$c->student_id][$k] = intval($c->count_played_by_student);
        }

        $studentsPerChallengeStats = array_values($studentsPerChallengeStats);

        $challengesPerStateStatsQ = $this->db->query("SELECT  SL.state, count(CH.challenge_id) AS count_challenges
          FROM class_compete.challenges CH
          JOIN class_compete.teachers T ON CH.user_id=T.user_id
          JOIN class_compete.school SL ON T.school_id=SL.school_id
          GROUP BY SL.state")->result();

        $challengesPerStateStats = array(array('State', 'Challenges'));
        foreach ($challengesPerStateStatsQ as $c) {
            $challengesPerStateStats[] = array(
                $c->state,
                $c->count_challenges,
            );
        }


        $data = new stdClass();
        $data->challengeStats = $challengeStats;
        $data->studentsPerChallengeStats = $studentsPerChallengeStats;
        $data->stateStats = $challengesPerStateStats;

        $data->content = $this->load->view('reporting/reporting-new', $data, true);

        $this->load->view('compete', $data);
    }

}