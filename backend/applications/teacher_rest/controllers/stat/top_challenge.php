<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/6/13
 * Time: 11:16 AM
 */
class Top_challenge extends REST_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('y_reporting/reportlib');

        function sort_by_played_times($a, $b){
            return $b['played_times'] - $a['played_times'];
        }

        function sort_by_played_times_percent($a, $b){
            return $b['class_statistic'] - $a['class_statistic'];
        }
    }

    public function index_get(){
        /** calculating data for top 3 challenges */

        $data = new stdClass();
        $challenges = $this->report_model->get_challenges_created_by_teacher(TeacherHelper::getUserId());
        $top_challenges = array();
        $amount_played_times = 0;
        foreach($challenges as $challenge=>$val){
            $top_challenges[$challenge]['challenge_name'] = $val->getName();
            $top_challenges[$challenge]['challenge_id'] = $val->getChallengeId();
            $played_times = $this->report_model->get_count_of_challenge_played_times($val->getChallengeId());
            $amount_played_times += $played_times;
            $top_challenges[$challenge]['played_times'] = $played_times;

        }
        usort($top_challenges,'sort_by_played_times');
        $top_challenges = array_slice($top_challenges, 0, 3, true);

        foreach($top_challenges as $challenge => $val){
            if($val['played_times'] === 0){
                $top_challenges[$challenge]['played_times_percent'] = 0;
            }else{
                $top_challenges[$challenge]['played_times_percent'] = round(($val['played_times'] / $amount_played_times) * 100,2);;
            }

        }

        $data->top_challenges = $top_challenges;

        $this->response($data);
    }

}