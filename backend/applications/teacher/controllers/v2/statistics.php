<?php
/**
 * Statistics for classrooms and students
 */
class Statistics extends MY_Controller{

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
        $this->load->library('propellib');
        $this->load->library('form_validation');
    }

	/**
	 * Shows statistics for classroom:
	 * - Challenge average score for classroom & USA, for time period
	 */
    public function classroom(){
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
	public function ajax_stats_classroom() {
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
			if (isset($filters['period_type'])) { $period_type = $filters['period_type']; }
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
		}
		else { $out['error'] = 'Class id not set'; }

		$this->output->set_output(json_encode($out));
	}

	//****************************************************************************

	/**
	 * Shows statistic for student:
	 * - Challenge average score for student, for time period
	 */
    public function student(){
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
	public function ajax_stats_student() {
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
			if (isset($filters['period_type'])) { $period_type = $filters['period_type']; }
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
		}
		else { $out['error'] = 'Class id or Student id not set'; }

		$this->output->set_output(json_encode($out));
	}

}