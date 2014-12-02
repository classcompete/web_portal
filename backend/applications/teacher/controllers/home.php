<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/24/13
 * Time: 10:42 AM
 * To change this template use File | Settings | File Templates.
 */
class Home extends MY_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->model('x_users/users_model');
        $this->load->model('x_class/class_model');
        $this->load->model('x_class_student/class_student_model');
        $this->load->model('x_challenge/challenge_model');
        $this->load->model('x_reporting/report_model');
        $this->load->model('x_users/teacher_model');

        function sort_by_played_times($a, $b){
            return $b['played_times'] - $a['played_times'];
        }
    }

    public function index(){

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('home/index/' . $uri);
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

        /**
         * get students count
         * */
        $data->total_teacher_studetns = $this->class_student_model->count_students_in_teacher_class(TeacherHelper::getId());
        $data->total_students = $this->class_student_model->getStudentCount();
        $array_of_num_students = str_split($data->total_students);
        $data->total_students_sparkline = implode(',',$array_of_num_students);


        /**
         * get total teachers
         * */

        $data->total_teacher = $this->teacher_model->get_teacher_count();
        $array_of_num_teacher = str_split($data->total_teacher);
        $data->total_teacher_sperkline = implode(',',$array_of_num_teacher);

        /**
         * get count of current teacher class
         * */
        $this->class_model->setTeacherId(TeacherHelper::getId());
        $data->total_classes = $this->class_model->getTotalClassesByTeacherId();

        /**
         * get count of  challenges
         * */
        $data->total_teacher_challenges = $this->challenge_model->getTotalTeacherChallenges(TeacherHelper::getUserId());
        $data->total_challenge = $this->challenge_model->getTotalChallenges();

        /** split total challenge to string - used for sparkline char */
        $array_num_of_challenge = str_split($data->total_challenge);
        $data->total_challenge_sparkline = implode(",", $array_num_of_challenge);


        $data->challenges_in_market = $this->challenge_model->getTotalChallenges();

        /** getting data for student statistic in challenges - played times */

        $class_list = $this->class_model->getList();

        if($class_list->getFirst() != null){
            foreach($class_list as $class=>$val){
                $data->classrom[$class]['class_id'] = $val->getClassId();
                $data->classrom[$class]['class_name'] = $val->getName();
            }

            $students_in_class  = $this->report_model->get_students_in_class($class_list->getFirst()->getClassId());
            /** @var $user PropUser */
            /** @var $student_data PropStudent */
            foreach($students_in_class as $k=>$v){
                $data->student_played_times[$k]['user_id']              = $v->getPropStudent()->getPropUser()->getUserId();
                $data->student_played_times[$k]['student_firstname']       = $v->getPropStudent()->getPropUser()->getFirstName();
                $data->student_played_times[$k]['student_lastname']        =  $v->getPropStudent()->getPropUser()->getLastName();
                $data->student_played_times[$k]['number_of_challenges']    = $this->report_model->count_students_challenges_by_class_id($v->getPropStudent()->getStudentId(),$class_list->getFirst()->getClassId());
            }
        }


        /** top 5 challenge */

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
        $top_challenges = array_slice($top_challenges, 0, 5, true);

        foreach($top_challenges as $challenge => $val){
            if($val['played_times'] === 0){
                $top_challenges[$challenge]['played_times_percent'] = 0;
            }else{
                $top_challenges[$challenge]['played_times_percent'] = round(($val['played_times'] / $amount_played_times) * 100,2);;
            }

        }

        $data->top_challenges = $top_challenges;

        $data->content = $this->prepareView('x_home_teacher', 'home', $data);
        $this->load->view(config_item('teacher_template'), $data);
    }


}