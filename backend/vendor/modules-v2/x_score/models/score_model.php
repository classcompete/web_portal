<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/8/14
 * Time: 1:37 PM
 */
class Score_model extends CI_Model{


    public function getLastChallengeByStudentId($studentId){

        $lastChallenge = $this->db->where('student_id',$studentId)
                                    ->order_by('score_id','ASC')
                                    ->where('class_id > ','0')
                                    ->limit(1)
                                    ->get('scores')->row();
        return $lastChallenge;
    }

    public function getClassScoreByChallengeAndClass($challengeId, $classId){
        $classScore = $this->db->select_avg('score_average')
                                ->where('challenge_Id', $challengeId)
                                ->where('class_id',$classId)->get('scores')->row();
        return $classScore->score_average;
    }

    public function getGlobalClassScoreByChallenge($challengeId){
        $globalScore = $this->db->select_avg('score_average')
            ->where('challenge_id', $challengeId)
            ->get('scores')->row();
        return $globalScore->score_average;
    }

    public function getDetailStudentScore($studentId){

        $stats = $this->db->select('challenges.name,scores.class_id,scores.challenge_id')
            ->select_avg('scores.score_average')
            ->group_by('scores.challenge_id')
            ->where('student_id',$studentId)
            ->where('scores.class_id >','0')
            ->join('challenges','challenges.challenge_id = scores.challenge_id')
            ->get('scores')->result_array();
        return $stats;
    }

    public function getDetailClassScoreByChallengeAndClass($challengeId,$classId){
        $classScore = $this->db->select_avg('score_average')
                        ->where('challenge_Id', $challengeId)
                        ->where('class_id',$classId)->get('scores')->row();

        return $classScore->score_average;
    }

    public function getDetailGlobalClassScoreByChallenge($challengeId){
        $globalScore = $this->db->select_avg('score_average')
            ->where('challenge_id', $challengeId)
            ->get('scores')->row();
        return $globalScore->score_average;
    }


}