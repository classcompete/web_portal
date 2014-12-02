<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 10/31/13
 * Time: 3:46 PM
 */
class Home extends REST_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->model('y_class/class_model');
        $this->load->model('y_class_student/class_student_model');
        $this->load->model('y_challenge/challenge_model');
        $this->load->library('y_user/teacherlib');
        $this->load->library('y_user/studentlib');

        function sort_by_played_times($a, $b){
            return $b['played_times'] - $a['played_times'];
        }
    }

    public function index_get(){

        $data = array();

        /*
         * get students count
         * */
        $data['teacher_stats']['total_students'] = $this->class_student_model->getStudentCount();
        $total_students = $this->class_student_model->getAmountStudentCount();
        $array_of_num_students = str_split($total_students);
        $data['class_compete_total']['students']['total_students_sparkline'] = implode(',',$array_of_num_students);
        $data['class_compete_total']['students']['total_students'] = $total_students;


        /**
         * get total teachers
         * */

        $data['teacher_stats']['total_teachers'] =  $this->teacher_model->get_teacher_count();
        $array_of_num_teacher = str_split($data['teacher_stats']['total_teachers']);
        $data['class_compete_total']['teachers']['total_teachers_sparkline'] = implode(',',$array_of_num_teacher);
        $data['class_compete_total']['teachers']['total_teachers'] = $data['teacher_stats']['total_teachers'];

        /*
         * get count of current teacher class
         * */
        $this->class_model->setTeacherId(TeacherHelper::getId());
        $data['teacher_stats']['total_classes'] = $this->class_model->getTotalClassesByTeacherId();

        /*
         * get count of  challenges
         * */
        $data['teacher_stats']['total_challenges'] = $this->challenge_model->getTotalChallengeByTeacherId(TeacherHelper::getUserId());

        /** split total challenge to string - used for sparkline char */
        $array_num_of_challenge = str_split($this->challenge_model->getTotalChallenges());
        $data['class_compete_total']['challenges']['total_challenge_sparkline'] = implode(",", $array_num_of_challenge);
        $data['class_compete_total']['challenges']['total_challenge'] = $this->challenge_model->getTotalChallenges();

        $data['teacher_stats']['total_marketplace'] = $this->challenge_model->getTotalChallenges();


        $this->response($data,200);
    }

}