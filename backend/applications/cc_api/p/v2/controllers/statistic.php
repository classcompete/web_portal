<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/8/14
 * Time: 12:27 PM
 */
class Statistic extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('x_score/scorelib');

        if(ParentHelper::isParent() === false){
            $this->response(null,401);
        }
    }

    public function index_get(){
        $response = array();

        $this->parent_student_model->filterByParentId(ParentHelper::getId());
        $students = $this->parent_student_model->getList();
        $studentsLength = $this->parent_student_model->getFoundRows();

        for($i = 0; $i < $studentsLength; $i++){
            $tmpStudent = $students[$i];
            $response[$i]['name'] = $tmpStudent->getPropStudent()->getPropUser()->getFirstName() .' '. $tmpStudent->getPropStudent()->getPropUser()->getLastName();
            $response[$i]['studentId'] = $tmpStudent->getStudentId();
            $response[$i]['scores'] = array();

            // get student , school and usa average score

            $detailStudentScores = $this->score_model->getDetailStudentScore($tmpStudent->getStudentId());

            $studentAverageScore = 0;
            $classAverageScore = 0;
            $usaAverageScore = 0;


            if(count($detailStudentScores) > 0){
                foreach($detailStudentScores as $score){
                    $studentAverageScore += $score['score_average'];


                    $classAverageScore += $this->score_model->getDetailClassScoreByChallengeAndClass($score['challenge_id'], $score['class_id']);
                    $usaAverageScore += $this->score_model->getGlobalClassScoreByChallenge($score['challenge_id']);
                }
                $studentAverageScore = $studentAverageScore/count($detailStudentScores);
                if($classAverageScore > 0 ){
                    $classAverageScore = $classAverageScore / count($detailStudentScores);
                }
                if($usaAverageScore > 0){
                    $usaAverageScore = $usaAverageScore / count($detailStudentScores);
                }
            }

            // get school average schore
            if(!empty($detailStudentScores)){
                $response[$i]['scores']['studentAverage'] = floatval(round($studentAverageScore,2));
                $response[$i]['scores']['classAverage'] = floatval(round($classAverageScore,2));
                $response[$i]['scores']['usaAverage'] = floatval(round($usaAverageScore,2));
            }else{
                $response[$i]['scores']['studentAverage'] = 0;
                $response[$i]['scores']['classAverage'] = 0;
                $response[$i]['scores']['usaAverage'] = 0;
            }

        }

        $this->response($response,200);

    }

    public function id_get($studentId){
        $resp = new stdClass();
        $resp->response = array();

        $studentScore = $this->score_model->getDetailStudentScore($studentId);
        $studentScoreLength = count($studentScore);

        for($i = 0; $i < $studentScoreLength; $i ++){
            $tmpStudentScore = $studentScore[$i];
            $resp->response[$i]['name'] = $tmpStudentScore['name'];
            $resp->response[$i]['stat'][1]['score'] = round($tmpStudentScore['score_average'],2);
            $resp->response[$i]['stat'][1]['name'] = 'Student average';
            $resp->response[$i]['stat'][2]['score'] = round($this->score_model->getDetailClassScoreByChallengeAndClass($tmpStudentScore['challenge_id'], $tmpStudentScore['class_id']),2);
            $resp->response[$i]['stat'][2]['name'] = 'Class average';
            $resp->response[$i]['stat'][3]['score'] = round($this->score_model->getDetailGlobalClassScoreByChallenge($tmpStudentScore['challenge_id']),2);
            $resp->response[$i]['stat'][3]['name'] = 'USA average';
        }


        $this->response($resp);
    }

}