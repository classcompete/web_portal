<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/24/13
 * Time: 11:50 AM
 * To change this template use File | Settings | File Templates.
 */
class Reporting extends MY_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('x_reporting/reportlib');
        $this->load->library('x_reporting_new/reportnewlib');
        $this->load->model('x_challenge/challenge_model');
        $this->load->model('x_class/class_model');
        $this->load->model('x_class_student/class_student_model');
        $this->load->model('x_challenge/challenge_model');
        $this->load->model('x_challenge_class/challenge_class_model');
        $this->load->model('x_question/question_model');
        $this->load->model('x_users/users_model');
        $this->load->model('x_users/teacher_model');
        $this->load->library('propellib');
        $this->load->library('form_validation');

        function sort_by_played_times($a, $b){
            return $b['played_times'] - $a['played_times'];
        }

        function sort_by_played_times_percent($a, $b){
            return $b['class_statistic'] - $a['class_statistic'];
        }

        $class_id_from_url = $this->uri->uri_to_assoc();
    }
    public function statistic(){

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('reporting/index/' . $uri);
        }

        $data = new stdClass();

        $this->challenge_model->setTeacherId(TeacherHelper::getId());
        $challenges = $this->challenge_model->getListForTeacher();

        /** getting data for challenge statistic by played times */
        $data->played_times = array();
        foreach($challenges as $challenge=>$val){
            $data->played_times[$challenge]['challenge_name']   = $val->getPropChallenge()->getName();
            $data->played_times[$challenge]['played_times']     = $this->challenge_model->get_challenge_played_times($val->getChallengeId(), $val->getClassId());
            $data->played_times[$challenge]['class_name']      = $val->getPropclas()->getName();
        }

        /** getting data for student statistic in classroom & each challenge */

        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $class_list = $this->class_model->getList();

        if($class_list->getFirst() != null){
            foreach($class_list as $class=>$val){
                $data->classrom[$class]['class_id'] = $val->getClassId();
                $data->classrom[$class]['class_name'] = $val->getName();
            }

            $students = $this->class_model->get_students_from_class($class_list->getFirst()->getClassId());

            foreach($students as $student=>$v){

                $data->student_statistic_class_student[$student]['user_id'] = $v->getUserId();
                $data->student_statistic_class_student[$student]['first_name'] = $v->getFirstName();
                $data->student_statistic_class_student[$student]['last_name'] = $v->getLastName();
            }

            if ($students->getFirst() !== null){
                $student_id = $this->report_model->get_student_id($students->getFirst()->getUserId());

                $challenges_in_classroom = $this->report_model->get_student_classrooms($class_list->getFirst()->getClassId(),$student_id );

                foreach($challenges_in_classroom as $k=>$v){
                    $answers                        = $this->reportlib->get_student_classrooms_answers($v['challenge_id'], $student_id);
                    $data->student_statistic[$k]['challenge_name']     =  $v['name'];
                    $data->student_statistic[$k]['challenge_id']       =  $v['challenge_id'];
                    $data->student_statistic[$k]['correct_answers']    = $answers['correct'];
                    $data->student_statistic[$k]['incorrect_answers']  = $answers['incorrect'];
                    $data->student_statistic[$k]['total_duration']     = $this->report_model->get_student_classrooms_duration($student_id, $v['challenge_id']);
                    $data->student_statistic[$k]['coins_collected']    = $this->report_model->get_student_coins_by_challenge($student_id,$v['challenge_id']);
                }
            }

            /** getting data for student statistic by played times */

            $students_in_class  = $this->report_model->get_students_in_class($class_list->getFirst()->getClassId());
            /** @var $user PropUser */
            /** @var $student_data PropStudent */
            foreach($students_in_class as $k=>$v){
                $data->student_played_times[$k]['user_id']                  = $v->getPropStudent()->getPropUser()->getUserId();
                $data->student_played_times[$k]['student_firstname']        = $v->getPropStudent()->getPropUser()->getFirstName();
                $data->student_played_times[$k]['student_lastname']         =  $v->getPropStudent()->getPropUser()->getLastName();
                $data->student_played_times[$k]['number_of_challenges']     = $this->report_model->count_students_challenges_by_class_id($v->getPropStudent()->getStudentId(),$class_list->getFirst()->getClassId());
            }
        }

        $data->content = $this->prepareView('x_reporting', 'statistic_reporting', $data);
        $this->load->view(config_item('teacher_template'), $data);
    }

    public function basic(){

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('question/basic/'. $uri);
        }

        $data = new stdClass();

        /** getting data for geo chart running challenges */
        $challenge_list = $this->challenge_model->getList();

        $challenge_list_state = array();
        foreach($challenge_list as $challenge=>$data){
            $state = $this->teacher_model->get_state($data->getUserId());
            if($state !== false){
                if(isset($challenge_list_state[$state->getState()]) === false){
                    $challenge_list_state[$state->getState()] = 0;
                }
                $challenge_list_state[$state->getState()] += 1 ;
            }

        }
        $data->geoChartData = array();
        $data->geoChartData[0] = array('State','Number of challenges');
        foreach($challenge_list_state as $key=>$val){
            $data->geoChartData[] = array($key,$val);
        }

        /** getting data for challenge class statistic */

        $challenges = $this->challenge_model->getList();
//            $this->report_model->get_challenges_list(TeacherHelper::getId());
        foreach($challenges as $challenge=>$challenge_val){
            $data->challenges[$challenge]['challenge_name'] = $challenge_val->getName();
            $data->challenges[$challenge]['challenge_id']   = $challenge_val->getChallengeId();
        }


        if(isset($challenges) === true && empty($challenges) === false){
            $data->challenge_class_statistic = $this->generate_challenge_class_statistic($challenges->getFirst()->getChallengeId());
        }else{
            $data->challenge_class_statistic = false;
        }

        /** calculating data for top 3 challenges */
        $top_five_challenges = $challenges;
        $top_challenges = array();
        $amount_played_times = 0;
        foreach($top_five_challenges as $challenge=>$val){
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


        /** top 3 class */
//        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $class_statistic = $this->class_model->getList();


        if(empty($class_statistic) === false){
            foreach($class_statistic as $class=>$val){
                $data->class_statistic[$class]['class_name'] = $val->getName();
                $data->class_statistic[$class]['class_statistic'] = $this->reportlib->get_amount_statistic_correct_answers($val->getClassId());
            }
            if(isset($data->class_statistic) === true){
                usort($data->class_statistic,'sort_by_played_times_percent');
                $data->class_statistic = array_slice($data->class_statistic, 0, 3, true);
            }
        }


        /** getting data for top 3 students */
//        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $teacher_classes = $this->class_model->getList();
        $data->teacher_classes = $teacher_classes;

        if($teacher_classes->getFirst() != null){
            $first_class = $teacher_classes->getFirst();
            $data->top_three_students = $this->reportlib->get_top_three_students_in_class($first_class->getClassId());
            $data->bottom_three_students = $this->reportlib->get_bottom_three_students_in_class($first_class->getClassId());
        }


        $data->content = $this->prepareView('x_reporting', 'basic_reporting', $data);
        $this->load->view(config_item('admin_template'), $data);
    }


    /** Functions for getting statistic for 1. report     */

    /**
     * Function for getting statistic of students for all challenges on specific classroom
     * @params: class_id
     * @out: list of students {student_id, student_firstname,student_lastname,number_of_played_challenges}
     */
    public function ajax_report_classroom_stats(){

        $class_id           = $this->input->post('class_id');
        $students_in_class  = $this->report_model->get_students_in_class($class_id);
        $data                = array();

        /** @var $user PropUser */
        /** @var $student_data PropStudent */
        foreach($students_in_class as $k=>$v){
            $data[$k]['student_id']              = $v->getPropStudent()->getStudentId();
            $data[$k]['student_firstname']       = $v->getPropStudent()->getPropUser()->getFirstName();
            $data[$k]['student_lastname']        =  $v->getPropStudent()->getPropUser()->getLastName();
            $data[$k]['number_of_challenges']    = $this->report_model->count_students_challenges_by_class_id($v->getPropStudent()->getStudentId(),$class_id);
        }

        $out = $this->reportlib->get_table_student_statistic_played_challenges($data);

        $this->output->set_output($out);
    }

    /**
     * Function for getting statistic of played challenges for specific user
     * @params: class_id, student_id
     * @out:    list of challenges {challenge_name, number_of_played_times for specific challenge}
     */
    public function ajax_report_classroom_stats_details(){
       $class_id       = $this->input->post('class_id');
       $user_id     = $this->input->post('student_id');
       $student_id                 = $this->report_model->get_student_id($user_id);
       $data            = array();
       $challenges     = $this->report_model->get_student_challenges_by_class_id($class_id, $student_id);

       foreach($challenges as $k=>$v){
           $data[$k]['challenge_name'] =  $v['name'];
           $data[$k]['number_of_played_times'] = $this->report_model->count_students_challenge_played_times($student_id, $v['challenge_id']);
       }

       $out = $this->reportlib->get_table_student_statistic_details($data);

       $this->output->set_output($out);
    }


    /** Function for getting statistic for report 2 */

    public function ajax_report_students_stats(){
        $user_id                    = $this->input->post("user_id");
        $class_id                   = $this->input->post('class_id');
        $student_id                 = $this->report_model->get_student_id($user_id);
        $challenges_in_classroom    = $this->report_model->get_student_classrooms($class_id, $student_id);
        $data                       = array();


        foreach($challenges_in_classroom as $k=>$v){
            $answers                        = $this->reportlib->get_student_classrooms_answers($v['challenge_id'], $student_id);
            $data[$k]['challenge_name']     =  $v['name'];
            $data[$k]['challenge_id']       =  $v['challenge_id'];
            $data[$k]['correct_answers']    = $answers['correct'];
            $data[$k]['incorrect_answers']  = $answers['incorrect'];
            $data[$k]['total_duration']     = $this->report_model->get_student_classrooms_duration($student_id, $v['challenge_id']);
            $data[$k]['coins_collected']    = $this->report_model->get_student_coins_by_challenge($student_id,$v['challenge_id']);
        }

        $out = $this->reportlib->get_table_student_statistic($data);

        $this->output->set_output($out);

    }

    /** Function for getting top 2 students */

    public function ajax_get_top_3_students(){
        $class_id = $this->input->post('class_id');
        $students = $this->reportlib->get_top_three_students_in_class($class_id);

        $this->output->set_output(json_encode($students));
    }

    public function ajax_get_bottom_3_students(){
        $class_id = $this->input->post('class_id');
        $students = $this->reportlib->get_bottom_three_students_in_class($class_id);

        $this->output->set_output(json_encode($students));
    }

    /** Function for getting data for challenge statistic by classroom */
    private function generate_challenge_class_statistic($challenge_id){

        /** get classes for $challenge_id */
        $challenge_class_statistic      =   array();
        $challenge_class_statistic[0]   =   array('Name', 'Played times', 'Students', 'Average score',);
        $data                           =   array();
        $classes                        =   $this->report_model->admin_get_classes_with_challenge($challenge_id);

        foreach($classes as $class=>$val){
            $data[$class]['class_name']           = $val->getPropClas()->getName();
            $data[$class]['students_in_class']    = $this->report_model->get_number_of_students_in_class($val->getPropClas()->getClassId());
            $data[$class]['played_times']         = $this->report_model->get_classroom_played_times($challenge_id, $val->getPropClas()->getClassId());
        }

        foreach($data as $k=>$v){

            $challenge_class_statistic[count($challenge_class_statistic)] = array($v['class_name'],$v['played_times'],$v['students_in_class'],0);
        }

        return $challenge_class_statistic;
    }

    public function ajax_get_challenge_classroom_statistic(){
        $challenge_id = $this->input->post('challenge_id');

        $data = $this->generate_challenge_class_statistic($challenge_id);

        $this->output->set_output(json_encode($data));
    }

    /**
     *  Function for getting individually stats for challenge
     *  @params: class_id , $user_id
     *  @out: table html with data
     */
    public function ajax_report_student_stats_individually_challenge(){
        $class_id   = $this->input->post('class_id');
        $user_id    = $this->input->post('user_id');
        $data = array();
        $student_id                 = $this->report_model->get_student_id($user_id);

        $this->reportnew_model->filterByStudentId($student_id);
        $this->reportnew_model->filterByClassId($class_id);
        $this->reportnew_model->set_order_by(PropScorePeer::CREATED);
        $this->reportnew_model->set_order_by_direction(Criteria::DESC);
        $scores = $this->reportnew_model->getList();


        foreach($scores as $score=>$score_val){
            $data[$score]['date'] = date('m/d/Y h:i a', strtotime($score_val->getCreated()) - (-1 * AdminHelper::getTimezoneDiff() *60*60));
            $data[$score]['challenge_name'] = $score_val->getPropChallenge()->getName();
            $data[$score]['percentage'] = $score_val->getScoreAverage();
            $data[$score]['correct_answers'] = $score_val->getNumCorrectQuestions();
            $data[$score]['incorrect_answers'] = $score_val->getNumTotalQuestions() - $score_val->getNumCorrectQuestions();
            $data[$score]['time_on_course'] = $score_val->getTotalDuration();
            $data[$score]['coins_collected']    = $score_val->getNumCoins();
        }

        $out = $this->reportnewlib->get_table_student_statistic_individually_challenge($data);

        $this->output->set_output($out);
    }

    /**
     *  Function for getting global student stats
     *  @params: user_id
     *  @out:
     * */
    public function ajax_report_student_global_stats(){
        $class_id   = $this->input->post('class_id');
        $user_id    = $this->input->post('user_id');
        $student_id                 = $this->report_model->get_student_id($user_id);
        $out = array();

            $out[0]   =   array('Name', 'Student', 'Classroom', 'USA',);

            $this->reportnew_model->filterByStudentId($student_id);
            $this->reportnew_model->filterByClassId($class_id);
            $this->reportnew_model->set_group_by(PropScorePeer::CHALLENGE_ID);
            $scores = $this->reportnew_model->getList();

            $student_challenge_score = $this->reportnew_model->getStudentGlobalScoreChallengeInClass($student_id, $class_id);

            $all_student_in_class_challenge_score = $this->reportnew_model->getAllStudentsGlobalScoreChallengeInClass($class_id);

            $all_student_challenge_score = $this->reportnew_model->getAllStudentGlobalChallengeScore();

            foreach($scores as $score_key=>$score_val){
               $out[count($out)] = array(
                    $score_val->getPropChallenge()->getName(),
                    round($student_challenge_score[$score_val->getChallengeId()]['score'],2),
                    round($all_student_in_class_challenge_score[$score_val->getChallengeId()]['score'],2),
                    round($all_student_challenge_score[$score_val->getChallengeId()]['score'],2)
                );
            }


        $this->output->set_output(json_encode($out));

    }

    public function r_new(){
        $class_id = $this->input->post('class_id');
        $out = array();

        $this->challenge_class_model->filterByClassId($class_id);
        $challenges = $this->challenge_class_model->getList();

        $all_student_in_class_challenge_score = $this->reportnew_model->getAllStudentsGlobalScoreChallengeInClass($class_id);
        $all_student_challenge_score = $this->reportnew_model->getAllStudentGlobalChallengeScore();

        $out[0]   =   array('Name', 'Student Average Score', 'Universe Average Score');

        if($challenges->getFirst() != null){
            foreach($challenges as $challenge_key=>$challenge_val){
                $out[count($out)] = array(
                    $challenge_val->getPropChallenge()->getName(),
                    isset($all_student_in_class_challenge_score[$challenge_val->getChallengeId()]['score']) === true ? round($all_student_in_class_challenge_score[$challenge_val->getChallengeId()]['score'],2):0,
                    isset($all_student_challenge_score[$challenge_val->getChallengeId()]['score']) === true ? round($all_student_challenge_score[$challenge_val->getChallengeId()]['score'],2):0
                );
            }
        }else{
            $out['error'] = 'This class has no corresponding data';
        }

        $this->output->set_output(json_encode($out));
    }

    public function ajax_report_student_stats_classroom(){
        $class_id = $this->input->post('class_id');
        $out = array();

        $this->challenge_class_model->filterByClassId($class_id);
        $challenges = $this->challenge_class_model->getList();

        $all_student_in_class_challenge_score = $this->reportnew_model->getAllStudentsGlobalScoreChallengeInClass($class_id);
        $all_student_challenge_score = $this->reportnew_model->getAllStudentGlobalChallengeScore();

        $out[0]   =   array('Name', 'Classroom', 'USA');

        if($challenges->getFirst() != null){
            foreach($challenges as $challenge_key=>$challenge_val){
                $out[count($out)] = array(
                    $challenge_val->getPropChallenge()->getName(),
                    isset($all_student_in_class_challenge_score[$challenge_val->getChallengeId()]['score']) === true ? round($all_student_in_class_challenge_score[$challenge_val->getChallengeId()]['score'],2):0,
                    isset($all_student_challenge_score[$challenge_val->getChallengeId()]['score']) === true ? round($all_student_challenge_score[$challenge_val->getChallengeId()]['score'],2):0
                );
            }
        }else{
            $out['error'] = 'This class has no corresponding data';
        }

        $this->output->set_output(json_encode($out));
    }

	/**
	 * Statistics: Average class scores by month
	 * - Score averages for a given classroom by month. The report will aggregate scores
	 * across all students and challenges in a given classroom for each month, starting with first
	 * month which has score data.
	 */
    public function ajax_report_class_stats_average_month(){
	    $classId = $this->input->post('class_id');
	    $minScoreAverage = floatval($this->input->post('min_score_average'));
        $out = array();
		$out[] = array('Month', 'Average class score');

	    $avgScores = $this->reportnew_model->getClassAverageScoreByMonths($classId, $minScoreAverage);
	    if (! empty($avgScores)) {
		    foreach ($avgScores as $item) {
			    $out[] = array($item['month'], round($item['month_average'], 2));
		    }
	    }
	    else { $out['error'] = 'This class has no corresponding data.'; }

		$this->output->set_output(json_encode($out));
    }

	/**
	 * Statistics: Class Scores Increase by Month
	 * - Increase of score averages for a given classroom by month. The report will aggregate scores
	 * across all students and challenges in a given classroom for each month, starting with first
	 * month which has score data. After that it will calculate increase in every month compared against
	 * prior month.
	 */
    public function ajax_report_class_stats_increase_month(){
	    $classId = $this->input->post('class_id');
	    $minScoreAverage = floatval($this->input->post('min_score_average'));
        $out = array();
		$out[] = array('Month', 'Increase of average class score (%)');

	    $avgScores = $this->reportnew_model->getClassAverageScoreByMonths($classId, $minScoreAverage);
	    if (! empty($avgScores)) {
		    if (count($avgScores) == 1) {
			    $out['error'] = 'Not enough data to calculate score increase: data for only one month is available.';
		    }
		    else {
			    $prevItem = array();
			    foreach ($avgScores as $item) {
				    if (empty($prevItem)) {
					    $out[] = array($item['month'], 0);
				    }
				    else {
					        //X = 100 x (currAvg - prevAvg) / prevAvg
					    $percent = 100 * ($item['month_average'] - $prevItem['month_average']) / $prevItem['month_average'];
						$out[] = array($item['month'], round($percent, 2));
				    }
				    $prevItem = $item;
			    }
		    }
	    }
	    else { $out['error'] = 'This class has no corresponding data.'; }

		$this->output->set_output(json_encode($out));
    }
}