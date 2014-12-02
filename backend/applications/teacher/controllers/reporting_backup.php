<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/24/13
 * Time: 11:50 AM
 * To change this template use File | Settings | File Templates.
 */
class reporting extends MY_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('x_reporting/reportlib');
        $this->load->model('x_challenge/challenge_model');
        $this->load->model('x_class/class_model');
        $this->load->model('x_class_student/class_student_model');
        $this->load->model('x_challenge/challenge_model');
        $this->load->model('x_challenge_class/challenge_class_model');
        $this->load->model('x_question/question_model');
        $this->load->model('x_users/users_model');
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

        $challenges = $this->report_model->get_challenges_list(TeacherHelper::getId());
        foreach($challenges as $challenge=>$val){
            $data->challenges[$challenge]['challenge_name'] = $val['name'];
            $data->challenges[$challenge]['challenge_id']   = $val['challenge_id'];
        }


        if(isset($challenges) === true && empty($challenges) === false){
            $data->challenge_class_statistic = $this->generate_challenge_class_statistic($challenges[0]['challenge_id']);
        }else{
            $data->challenge_class_statistic = false;
        }

        /** calculating data for top 3 challenges */
        $top_five_challenges = $this->report_model->get_challenges_created_by_teacher(TeacherHelper::getUserId());
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
        $this->class_model->filterByTeacherId(TeacherHelper::getId());
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
        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $teacher_classes = $this->class_model->getList();
        $data->teacher_classes = $teacher_classes;

        if($teacher_classes->getFirst() != null){
            $first_class = $teacher_classes->getFirst();
            $data->top_three_students = $this->reportlib->get_top_three_students_in_class($first_class->getClassId());
            $data->bottom_three_students = $this->reportlib->get_bottom_three_students_in_class($first_class->getClassId());
        }


        $data->content = $this->prepareView('x_reporting', 'basic_reporting', $data);
        $this->load->view(config_item('teacher_template'), $data);
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
        $classes                        =   $this->report_model->get_classes_with_challenge($challenge_id);

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

        $student_id                 = $this->report_model->get_student_id($user_id);
        $challenges_in_classroom    = $this->report_model->get_student_classrooms($class_id, $student_id);

        $challenges_id_in_classroom = array();

        foreach($challenges_in_classroom as $challenge=>$val){
            $challenges_id_in_classroom[] = intval($val['challenge_id']);
        }


        $score_data = $this->report_model->get_score_data_by_challenge_array_student_id($challenges_id_in_classroom, $student_id);
        $data = array();

        foreach($score_data as $score=>$val){
            $created_date = strtotime($val->getCreated());
            $data[$score]['date'] = date('m/d/Y h:i a', $created_date);

            $challenge_data = $this->challenge_model->get_challenge_data($val->getChallengeId());
            $answers_data   = $this->reportlib->get_answer_data_by_score_id($val->getScoreId());
            $number_of_questions = $this->question_model->count_questions_in_challenge($val->getChallengeId());

            $data[$score]['challenge_name'] = $challenge_data->getName();
            if($answers_data['correct'] + $answers_data['incorrect'] > 0){
                $data[$score]['percentage'] = round(($answers_data['correct']/($answers_data['correct'] + $answers_data['incorrect']))*100,2);
            }else{
                $data[$score]['percentage'] = 0;
            }

            $data[$score]['correct_answers'] = $answers_data['correct'];
            $data[$score]['incorrect_answers'] = $answers_data['incorrect'];
            $data[$score]['time_on_course'] = $val->getTotalDuration();
            $data[$score]['coins_collected']    = $this->reportlib->get_student_coins_for_challenge($val->getCreated(),$student_id,$val->getChallengeId());
        }

        $out = $this->reportlib->get_table_student_statistic_individually_challenge($data);

        $this->output->set_output($out);
    }

    /**
     *  Function for getting global student stats
     *  @params: user_id
     *  @out:
     * */
    public function ajax_report_student_global_stats(){
        $out      =   array();

        if(TeacherHelper::getSchoolId() != 0){
            $user_id    = $this->input->post('user_id');
            $class_id   = $this->input->post('class_id');
            $student_id = $this->report_model->get_student_id($user_id);

            $challenges_in_classroom    = $this->report_model->get_student_classrooms($class_id, $student_id);

            $out[0]   =   array('Name', 'Student Average Score', 'School Average Score', 'State Average Score',);
            $data                           =   array();


            foreach($challenges_in_classroom as $challenge=>$val){

                // check if we have result's in score table
                $scores = $this->report_model->get_score_data_by_challenge_array_student_id($val['challenge_id'], $student_id);
                if($scores->getFirst() != null){
                    $challenge_data = $this->challenge_model->get_challenge_data($val['challenge_id']);

                    $data[$challenge]['challenge_name'] = $challenge_data->getName();
                    $data[$challenge]['student_stats']  = $this->reportlib->get_students_average_result_for_teacher_challenge($val['challenge_id'], $student_id);
                    $data[$challenge]['school_stats']   = $this->reportlib->get_school_average_result_for_teacher_challenges($val['challenge_id']);
                    $data[$challenge]['state_stats']    = $this->reportlib->get_state_average_result_for_teacher_challenges($val['challenge_id']);
                }
            }

            foreach($data as $k=>$v){

                $out[count($out)] = array($v['challenge_name'],$v['student_stats'],$v['school_stats'],$v['state_stats']);
            }
        }else{
            $out['error'] = "You need to update you school in profile page";
        }


        $this->output->set_output(json_encode($out));

    }

    public function ajax_report_student_stats_classroom(){
        $class_id = $this->input->post('class_id');

        $out = array();
        $names = array();
        $student_stats = array();

        $students_with_score = $this->report_model->get_students_from_class_score_table($class_id);
        $students_in_class = $this->class_student_model->get_students_in_class($class_id);
        $challenges_in_class = $this->challenge_class_model->get_challenges_id_by_class($class_id);

        if($challenges_in_class->getFirst() !== null){
            $names[] = "Name";
            foreach($challenges_in_class as $challenge=>$val){
                $names[] = $this->challenge_model->get_challenge_name($val->getChallengeId());
            }

            $out[] = $names;
            foreach($students_in_class as $student=>$val){
                $student_stats[] = $val->getPropStudent()->getPropUser()->getFirstName() . ' '.$val->getPropStudent()->getPropUser()->getLastName();
                foreach($challenges_in_class as $challenge){
                    $student_stats[] =  $this->reportlib->get_students_average_result_for_teacher_challenge($challenge->getChallengeId(), $val->getStudentId());
                }
                $out[count($out)] = $student_stats;
                unset($student_stats);
            }

        }else{
            $out['error'] = 'This class has no corresponding data';
        }
        $this->output->set_output(json_encode($out));
    }

}