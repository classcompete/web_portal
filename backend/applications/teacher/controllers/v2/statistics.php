<?php

/**
 * Statistics for classrooms and students
 */
class Statistics extends MY_Controller
{

    public function __construct()
    {
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
        $this->load->library('propellib');
        $this->load->library('form_validation');
    }

    /**
     * Shows statistics for classroom:
     * - Challenge average score for classroom & USA, for time period
     */
    public function classroom()
    {
        $data = new stdClass();
        $data->params = $this->uri->uri_to_assoc();
        if (isset($data->params['from']) === true) {
            $data->params['from'] = date("m/d/Y", strtotime($data->params['from']));
        }
        if (isset($data->params['to']) === true) {
            $data->params['to'] = date("m/d/Y", strtotime($data->params['to']));
        }

        //Get list of all classrooms
        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $teacher_classes = $this->class_model->getList();
        $data->teacher_classes = $teacher_classes;

        $data->content = $this->load->view('reporting/classroom_statistics', $data, true);
        $this->load->view(config_item('teacher_template'), $data);
    }

    /**
     * Provider of classroom statistic for Ajax calls
     */
    public function ajax_stats_classroom()
    {
        $filters = $this->uri->uri_to_assoc();
        $out = array();

        if (isset($filters['class_id'])) {
            $class_id = $filters['class_id'];
            $this->challenge_class_model->filterByClassId($class_id);
            $classChallenges = $this->challenge_class_model->getList();

            /*
             period_type:
                1 - Current week
                2 - Last week (last 7 days)
                3 - Current month
                4 - Last month (last 30 days)
                5 - Last 3 months
                6 - Custom (from date to date)
             */
            $period_type = 1;
            if (isset($filters['period_type'])) {
                $period_type = $filters['period_type'];
            }
            $fromDateStr = '';
            $toDateStr = '';
            switch ($period_type) {
                case 1: //Current week
                    //$sunday = strtotime('-' . date('w', $date) . ' days', $date);
                    //$monday = strtotime('-' . (date('N', $date) - 1) . ' days', $date);
                    $fromDateStr = date('Y-m-d', strtotime('-' . (date('N') - 1) . ' days'));
                    break;
                case 2: //Last week
                    $fromDateStr = date('Y-m-d', strtotime("-7 days"));
                    break;
                case 3: //Current month
                    //$fromDateStr = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                    $fromDateStr = date('Y-m-01');
                    break;
                case 4: //Last month
                    $fromDateStr = date('Y-m-d', strtotime("-30 days"));
                    break;
                case 5: //Last 3 months
                    $fromDateStr = date('Y-m-d', strtotime("-90 days"));
                    break;
                case 6: //Custom
                    $fromDateSent = isset($filters['from']) ? $filters['from'] : 'now';
                    $toDateSent = isset($filters['to']) ? $filters['to'] : 'now';
                    $fromDateStr = date('Y-m-d', strtotime($fromDateSent));
                    $toDateStr = date('Y-m-d', strtotime($toDateSent));
                    break;
            }

            foreach ($classChallenges as $challenge) {
                if (round($this->challenge_model->getClassScoreByChallengeAndClass($challenge->getChallengeId(), $class_id, $fromDateStr, $toDateStr)) > 0) {
                    $row = array();
                    $row['challenge_name'] = $this->challenge_model->get_challenge_name($challenge->getChallengeId());
                    $row['class_avg'] = round($this->challenge_model->getClassScoreByChallengeAndClass($challenge->getChallengeId(), $class_id, $fromDateStr, $toDateStr));
                    $row['overall_avg'] = round($this->challenge_model->getGlobalClassScoreByChallenge($challenge->getChallengeId(), $fromDateStr, $toDateStr));
                    $out[] = $row;
                }
            }
        } else {
            $out['error'] = 'Class id not set';
        }

        $this->output->set_output(json_encode($out));
    }

    //****************************************************************************

    /**
     * Shows statistic for student:
     * - Challenge average score for student, for time period
     */
    public function student()
    {
        $data = new stdClass();
        $data->params = $this->uri->uri_to_assoc();
        if (isset($data->params['from']) === true) {
            $data->params['from'] = date("m/d/Y", strtotime($data->params['from']));
        }
        if (isset($data->params['to']) === true) {
            $data->params['to'] = date("m/d/Y", strtotime($data->params['to']));
        }

        //Get list of all classrooms
        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $teacher_classes = $this->class_model->getList();
        $data->teacher_classes = $teacher_classes;

        if (intval(@$data->params['class_id']) > 0) {
            $students = $this->class_model->get_students_from_class($data->params['class_id']);
        } else {
            $students = array();
        }

        $data->students = $students;


        $data->content = $this->load->view('reporting/student_statistics', $data, true);
        $this->load->view(config_item('teacher_template'), $data);
    }

    /**
     * Provider of student statistic for Ajax calls
     */
    public function ajax_stats_student()
    {
        $filters = $this->uri->uri_to_assoc();
        $out = array();

        if (isset($filters['class_id']) && isset($filters['student_id'])) {
            $class_id = $filters['class_id'];
            $student_id = $filters['student_id'];
            $this->challenge_class_model->filterByClassId($class_id);
            $classChallenges = $this->challenge_class_model->getList();

            /*
             period_type:
                1 - Current week
                2 - Last week (last 7 days)
                3 - Current month
                4 - Last month (last 30 days)
                5 - Last 3 months
                6 - Custom (from date to date)
             */
            $period_type = 1;
            if (isset($filters['period_type'])) {
                $period_type = $filters['period_type'];
            }
            $fromDateStr = '';
            $toDateStr = '';
            switch ($period_type) {
                case 1: //Current week
                    //$sunday = strtotime('-' . date('w', $date) . ' days', $date);
                    //$monday = strtotime('-' . (date('N', $date) - 1) . ' days', $date);
                    $fromDateStr = date('Y-m-d', strtotime('-' . (date('N') - 1) . ' days'));
                    break;
                case 2: //Last week
                    $fromDateStr = date('Y-m-d', strtotime("-7 days"));
                    break;
                case 3: //Current month
                    //$fromDateStr = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                    $fromDateStr = date('Y-m-01');
                    break;
                case 4: //Last month
                    $fromDateStr = date('Y-m-d', strtotime("-30 days"));
                    break;
                case 5: //Last 3 months
                    $fromDateStr = date('Y-m-d', strtotime("-90 days"));
                    break;
                case 6: //Custom
                    $fromDateSent = isset($filters['from']) ? $filters['from'] : 'now';
                    $toDateSent = isset($filters['to']) ? $filters['to'] : 'now';
                    $fromDateStr = date('Y-m-d', strtotime($fromDateSent));
                    $toDateStr = date('Y-m-d', strtotime($toDateSent));
                    break;
            }

            foreach ($classChallenges as $challenge) {
                if ($this->challenge_model->getStudentTotalPlayedChallenge($student_id, $challenge->getChallengeId(), $class_id, $fromDateStr, $toDateStr) > 0) {
                    $row = array();
                    $row['challenge_name'] = $this->challenge_model->get_challenge_name($challenge->getChallengeId());
                    $row['total_played'] = $this->challenge_model->getStudentTotalPlayedChallenge($student_id, $challenge->getChallengeId(), $class_id, $fromDateStr, $toDateStr);
                    $row['first_score'] = round($this->challenge_model->getStudentFirstScoreByChallengeAndClass($student_id, $challenge->getChallengeId(), $class_id, $fromDateStr, $toDateStr));
                    $row['student_avg'] = round($this->challenge_model->getStudentAverageScoreByChallengeAndClass($student_id, $challenge->getChallengeId(), $class_id, $fromDateStr, $toDateStr));
                    $row['class_avg'] = round($this->challenge_model->getClassScoreByChallengeAndClass($challenge->getChallengeId(), $class_id, $fromDateStr, $toDateStr));
                    $out[] = $row;
                }
            }
        } else {
            $out['error'] = 'Class id or Student id not set';
        }

        $this->output->set_output(json_encode($out));
    }

    //****************************************************************************

    /**
     * Shows statistic for student drilldown table:
     * - Scores for student, for time period
     */
    public function drilldown()
    {
        $data = new stdClass();
        $data->params = $this->uri->uri_to_assoc();
        if (isset($data->params['from']) === true) {
            $data->params['from'] = date("m/d/Y", strtotime($data->params['from']));
        }
        if (isset($data->params['to']) === true) {
            $data->params['to'] = date("m/d/Y", strtotime($data->params['to']));
        }

        //Get list of all classrooms
        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $teacher_classes = $this->class_model->getList();
        $data->teacher_classes = $teacher_classes;

        if (intval(@$data->params['class_id']) > 0) {
            $students = $this->class_model->get_students_from_class($data->params['class_id']);
        } else {
            $students = array();
        }

        $data->students = $students;


        $data->content = $this->load->view('reporting/drilldown_statistics', $data, true);
        $this->load->view(config_item('teacher_template'), $data);
    }

    /**
     * Provider of student drilldown table for Ajax calls
     */
    public function ajax_stats_drilldown(){
        $filters = $this->uri->uri_to_assoc();
        $out = array();

        if (isset($filters['class_id']) && isset($filters['student_id'])) {
	        $data = array();

	        $class_id = $filters['class_id'];
	        $student_id = $filters['student_id'];

            $period_type = 1;
            if (isset($filters['period_type'])) {
                $period_type = $filters['period_type'];
            }
            $fromDateStr = '';
            $toDateStr = '';
            switch ($period_type) {
                case 1: //Current week
                    //$sunday = strtotime('-' . date('w', $date) . ' days', $date);
                    //$monday = strtotime('-' . (date('N', $date) - 1) . ' days', $date);
                    $fromDateStr = date('Y-m-d', strtotime('-' . (date('N') - 1) . ' days'));
                    break;
                case 2: //Last week
                    $fromDateStr = date('Y-m-d', strtotime("-7 days"));
                    break;
                case 3: //Current month
                    //$fromDateStr = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                    $fromDateStr = date('Y-m-01');
                    break;
                case 4: //Last month
                    $fromDateStr = date('Y-m-d', strtotime("-30 days"));
                    break;
                case 5: //Last 3 months
                    $fromDateStr = date('Y-m-d', strtotime("-90 days"));
                    break;
                case 6: //Custom
                    $fromDateSent = isset($filters['from']) ? $filters['from'] : 'now';
                    $toDateSent = isset($filters['to']) ? $filters['to'] : 'now';
                    $fromDateStr = date('Y-m-d', strtotime($fromDateSent));
                    $toDateStr = date('Y-m-d', strtotime($toDateSent));
                    break;
            }


	        $this->reportnew_model->filterByStudentId($student_id);
	        $this->reportnew_model->filterByClassId($class_id);
	        if ($fromDateStr) {
		        $this->reportnew_model->filterByDateFrom($fromDateStr);
	        }
	        if ($toDateStr) {
		        $this->reportnew_model->filterByDateTo($toDateStr);
	        }
	        $this->reportnew_model->set_order_by(PropScorePeer::CREATED);
	        $this->reportnew_model->set_order_by_direction(Criteria::DESC);
	        $scores = $this->reportnew_model->getList();

	        foreach ($scores as $score => $score_val) {
		        $data[$score]['date'] = date('m/d/Y h:i a', strtotime($score_val->getCreated()) - (-1 * TeacherHelper::getTimezoneDifference() * 60 * 60));
		        $data[$score]['challenge_name'] = $score_val->getPropChallenge()->getName();
		        $data[$score]['percentage'] = $score_val->getScoreAverage();
		        $data[$score]['correct_answers'] = $score_val->getNumCorrectQuestions();
		        $data[$score]['incorrect_answers'] = $score_val->getNumTotalQuestions() - $score_val->getNumCorrectQuestions();
		        $data[$score]['time_on_course'] = $score_val->getTotalDuration();
	        }

	        $out = $this->create_table_stats_drilldown($data);
        }

        $this->output->set_output($out);
    }

    public function create_table_stats_drilldown($data){
        ob_start();
        ?>
	        <table id="stats_drilldown_table"
	               class="table table-condensed table-striped table-hover table-bordered pull-left dataTable"
	               style="font-size:14px">
	            <thead>
		            <tr role="row">
	                    <th style="width: 200px;" class="sorting" rowspan="1" colspan="1">
	                        Date
	                    </th>
	                    <th style="width: 200px;" class="sorting" rowspan="1" colspan="1">
	                        Challenge Name
	                    </th>
	                    <th style="width: 100px;" class="sorting" rowspan="1" colspan="1">
	                        Percentage
	                    </th>
	                    <th style="width: 100px;" class="sorting" rowspan="1" colspan="1">
	                        Correct Answers
	                    </th>
	                    <th style="width: 100px;" class="sorting" rowspan="1" colspan="1">
	                        Incorrect Answers
	                    </th>
	                    <th style="width: 100px;" class="sorting" rowspan="1" colspan="1">
	                        Time on Course
	                    </th>
		            </tr>
	            </thead>
	            <tbody>
		            <?php foreach ($data as $k => $v): ?>
		                <tr class="gradeA info">
		                    <td><?php echo $v['date']?></td>
		                    <td><?php echo $v['challenge_name']?></td>
		                    <td><?php echo $v['percentage']?></td>
		                    <td><?php echo $v['correct_answers']?></td>
		                    <td><?php echo $v['incorrect_answers']?></td>
		                    <td><?php echo $v['time_on_course']?></td>
		                </tr>
		            <?php endforeach;?>
	            </tbody>
	        </table>
        <?php
        $out =  ob_get_clean();
        return $out;
    }

}