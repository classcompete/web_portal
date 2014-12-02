<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/10/13
 * Time: 10:55 AM
 * To change this template use File | Settings | File Templates.
 */
class Report_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    /** Functions for getting statistic for 1. report     */

    /**
     * Function for counting challenges witch student play in specific classroom
     * @params: student_id, class_id
     * @out: number of played challenges
     * */
    public function count_students_challenges_by_class_id($student_id, $class_id){

        $query = $this->db
                        ->select('COUNT(challenge_classes.challenge_id) as count')
                        ->join('students','scores.student_id = students.student_id')
                        ->join('users','students.user_id = users.user_id')
                        ->join('challenge_classes','challenge_classes.challenge_id = scores.challenge_id')
                        ->join('classes','classes.class_id = challenge_classes.class_id')
                        ->join('challenges','challenges.challenge_id = scores.challenge_id')
                        ->where('classes.class_id',$class_id)
                        ->where('scores.student_id',$student_id)
                        ->get('scores')->row();
        return $query->count;
    }

    /**
     * Function for getting students from specific class
     * @params: class_id
     * @out;    list of student in specific class
     * */
    public function get_students_in_class($class_id){
        $query = PropClass_studentQuery::create()->filterByClassId($class_id)->find();
        return $query;
    }

    /**
     * Function for getting list of challenges witch student played
     * @params: class_id, student_id
     * @out:    list of challenges for specific student
     * */
    public function get_student_challenges_by_class_id($class_id, $student_id){

        $query = $this->db
            ->select('challenges.name, challenges.challenge_id')
            ->distinct('challenges.challenge_id')
            ->join('students','scores.student_id = students.student_id')
            ->join('users','students.user_id = users.user_id')
            ->join('challenge_classes','challenge_classes.challenge_id = scores.challenge_id')
            ->join('classes','classes.class_id = challenge_classes.class_id')
            ->join('challenges','challenges.challenge_id = scores.challenge_id')
            ->where('classes.class_id',$class_id)
            ->where('scores.student_id',$student_id)
            ->get('scores')->result_array();

        return $query;
    }

    /**
     * Function for counting how many times student played specific challenge
     * @params: student_id, challenge_id
     * @out:    number of played times for specific challenge
     * */

    public function count_students_challenge_played_times($student_id, $challenge_id){
        $query = $this->db
                ->select('COUNT(scores.challenge_id) as count')
                ->where('scores.student_id',$student_id)
                ->where('scores.challenge_id',$challenge_id)
                ->get('scores')->row();

        return $query->count;
    }

    /** Functions for getting statistic for 2. report     */

    public function get_student_id($user_id){
        $data = PropStudentQuery::create()->findOneByUserId($user_id);

        return $data->getStudentId();
    }

    public function get_student_classrooms($class_id, $student_id){
        $query = $this->db
            ->select('challenges.name, challenges.challenge_id')
            ->distinct('challenges.challenge_id')
            ->join('students','scores.student_id = students.student_id')
            ->join('users','students.user_id = users.user_id')
            ->join('challenge_classes','challenge_classes.challenge_id = scores.challenge_id')
            ->join('classes','classes.class_id = challenge_classes.class_id')
            ->join('challenges','challenges.challenge_id = scores.challenge_id')
            ->where('classes.class_id',$class_id)
            ->where('scores.student_id',$student_id)
            ->get('scores')->result_array();

        return $query;
    }
    public function get_student_classrooms_duration($student_id, $challenge_id){
        $scores = $this->db
                         ->select('scores.score_id, scores.total_duration')
                         ->where('scores.student_id',$student_id)
                         ->where('scores.challenge_id',$challenge_id)
                        ->get('scores')->result_array();

        $zero_hour = "00:00:00";
        $zero_time = strtotime($zero_hour);
        $minute = 0;
        $second = 0;
        $hour = 0;

        foreach($scores as $score=>$val){
            $array = explode(':',$val['total_duration']);
            $minute += intval($array[1]);
            $second += intval($array[2]);
            $hour   += intval($array[0]);
        }

        $convert = strtotime("+$minute minutes", $zero_time);
        $convert = strtotime("+$second seconds",$convert);
        $convert = strtotime("+$hour hours",$convert);

        $new_time = date("H:i:s", $convert);

        return $new_time;

    }

    /**
     * Function for getting earned coins - statistic in a classroom and each challenges
     * @params: challenge_id
     * @out:
     *  */
    public function get_student_coins_by_challenge($student_id,$challenge_id){
        $shop_transaction = PropShopTransactionQuery::create()
                                ->filterByChallengeId($challenge_id)
                                ->filterByStudentId($student_id)
                                ->withColumn('SUM(shop_transactions.num_coins)','total')
                                ->findOne();

        if($shop_transaction->getTotal() === null){
            return 0;
        }else{
            return $shop_transaction->getTotal();
        }

    }
    /**
     * Function for getting earned coins - statistic in a classroom and each challenges for score played log
     * @params: challenge_id
     * @out:
     *  */
    public function get_student_coins_by_score_log($created_data, $student_id,$challenge_id){
        $shop_transaction = PropShopTransactionQuery::create()
            ->filterByChallengeId($challenge_id)
            ->filterByStudentId($student_id)
            ->filterByCreated($created_data)
            ->find();

        return $shop_transaction;

    }

    public function get_questions_by_challenge_id($challenge_id){
        return PropChallengeQuestionQuery::create()->filterByChallengeId($challenge_id)->find();
    }
    public function get_answers_from_score_answers($challenge_id, $student_id){
        $query = $this->db
                    ->select('score_answers.question_id, score_answers.score_id, score_answers.choice_id, score_answers.text')
                    ->join('score_answers','scores.score_id = score_answers.score_id', 'left')
                    ->where('scores.challenge_id',$challenge_id)
                    ->where('scores.student_id',$student_id)
                    ->get('scores')->result_array();
        return $query;
    }

    /** Function for getting statistic for challenge classes statistic */

    /**
     * Function for getting classrooms by challenge_Id
     * @params: challenge_id
     * @out: propel object collection - classrooms
     * */
    public function get_classes_with_challenge($challenge_id){
        $classes = PropChallengeClassQuery::create()
                        ->filterByChallengeId($challenge_id)
                        ->usePropClasQuery()
                            ->filterByTeacherId(TeacherHelper::getId())
                        ->endUse()
                        ->find();

        return $classes;
    }

    /**
     * Function for getting classrooms by challenge_Id
     * @params: challenge_id
     * @out: propel object collection - classrooms
     * */
    public function admin_get_classes_with_challenge($challenge_id){
        $classes = PropChallengeClassQuery::create()
            ->filterByChallengeId($challenge_id)
            ->find();

        return $classes;
    }

    /**
     * Function for counting students in class
     * @params: class_id
     * @out: number of students in specific class
     * */
    public function get_number_of_students_in_class($class_id){
        $students = PropClass_studentQuery::create()
                        ->filterByClassId($class_id)
                         ->count();
        return $students;
    }


    /**
     * Function for counting classroom played times
     * @params challenge_id, class_id
     * @out: number of played times
     * */
    public function get_classroom_played_times($challenge_id, $class_id){
        $query = $this->db
                        ->select('scores.student_id')
                        ->distinct('scores.student_id')
                        ->join('class_students','class_students.student_id = scores.student_id')
                        ->where('class_students.class_id',$class_id)
                        ->where('scores.challenge_id',$challenge_id)
                        ->get('scores')->result_array();

        return count($query);
    }

    /**
     * Function for getting teacher challenges
     * @params teacher_id
     * @out: list of challenges
     * */
    public function get_challenges_list($teacher_id){
        $query = $this->db
                        ->select('challenges.name, challenges.challenge_id')
                        ->distinct('challenges.challenge_id')
                        ->join('challenge_classes','challenge_classes.challenge_id = challenges.challenge_id')
                        ->join('classes','classes.class_id = challenge_classes.class_id')
                        ->where('classes.teacher_id',$teacher_id)
                        ->get('challenges')->result_array();

        return $query;
    }

    /**
     * Function for getting challenges created by teacher
     * @params: teacher user_id
     * @out: list of challenges
     * */
    public function get_challenges_created_by_teacher($teacher_user_id){
        return PropChallengeQuery::create()->filterByUserId($teacher_user_id)->find();
    }

    public function get_count_of_challenge_played_times($challenge_id){
        return PropScoreQuery::create()->filterByChallengeId($challenge_id)->count();
    }

    /**
     * Function for getting list of teacher challenges by class_id
     * @params: class_id
     * @out:    list of challenges
     * */
    public function get_challenge_list_by_class_and_teacher_id($class_id){
        $query = $this->db
                        ->join('challenge_classes','challenge_classes.challenge_id = scores.challenge_id','left')
                        ->where('challenge_classes.class_id',$class_id)
                        ->get('scores')->result_array();
        return $query;
    }

    public function get_answers_from_score_answers_by_score_id($score_id){
        $query = $this->db
            ->select('score_answers.question_id, score_answers.score_id, score_answers.choice_id, score_answers.text')
            ->where('score_answers.score_id',$score_id)
            ->get('score_answers')->result_array();
        return $query;
    }

    public function get_students_with_scores(){
        $students = PropScoreQuery::create()
                        ->usePropChallengeQuery()
                            ->filterByUserId(TeacherHelper::getUserId())
                        ->endUse()
                    ->find();

        return $students;
    }

    public function get_student_score_answers($score_id){
        return PropScoreAnswerQuery::create()->filterByScoreId($score_id)->find();
    }
    public function get_correct_question_answer($question_id){
        return PropQuestionQuery::create()->findOneByQuestionId($question_id);
    }

    public function get_challenges_by_class_id($class_id){
        return PropChallengeClassQuery::create()->filterByClassId($class_id)->find();
    }
    public function is_challenge_student_in_score_table($challenge_id, $student_id){
        $score_data = PropScoreQuery::create()
                        ->filterByChallengeId($challenge_id)
                        ->filterByStudentId($student_id)
                        ->find();
        if($score_data->getFirst() != null){
            return true;
        }else {
            return false;
        }

    }

    public function get_score_answers_data_by_score_id($score_id){
        return PropScoreAnswerQuery::create()->findByScoreId($score_id);
    }

    /**
     * Function for getting score data by student challenges
     * */

    public function get_score_data_by_challenge_array_student_id($challenges, $student_id){
        $scores = PropScoreQuery::create()
                    ->filterByChallengeId($challenges)
                    ->filterByStudentId($student_id)
                  ->find();

        return $scores;
    }

    /**
     *  function for getting average time on app
     */

    public function get_average_time_game_app(){

        $score = PropScoreQuery::create()
                                ->groupByStudentId()
                                ->withColumn('SUM(total_duration_secs)','total','total_time')
                                ->withColumn('COUNT(challenge_id)','total_challenges')
                                ->withColumn('SUM(total_duration_secs) DIV COUNT(challenge_id)','average_time')
                                ->find();

        return $score;
    }

    public function get_challenge_classes_with_challenge_teacher_school($challenge_id){
        $challenge_classes = PropChallengeClassQuery::create()
                        ->filterByChallengeId($challenge_id)
                        ->usePropClasQuery()
                            ->usePropTeacherQuery()
                                ->filterBySchoolId(TeacherHelper::getSchoolId())
                            ->endUse()
                        ->endUse()
                    ->find();

        return $challenge_classes;
    }

    public function get_challenge_classes_with_challenge_teacher_state($challenge_id){
        $challenge_classes = PropChallengeClassQuery::create()
            ->filterByChallengeId($challenge_id)
                ->usePropClasQuery()
                    ->usePropTeacherQuery()
                        ->usePropSchoolQuery()
                            ->filterByState(TeacherHelper::getState())
                        ->endUse()
                    ->endUse()
                ->endUse()
            ->find();

        return $challenge_classes;
    }

    public function get_students_by_class_id($class){
        return PropClass_studentQuery::create()->filterByClassId($class)->find();
    }

    public function get_challenges_in_teacher_class($class_id){
        return PropChallengeClassQuery::create()
                    ->filterByClassId($class_id)
                    ->usePropClasQuery()
                        ->filterByTeacherId(TeacherHelper::getId())
                    ->endUse()
                ->find();
    }

    public function get_students_from_class_score_table($class_id){
        $query = $this->db
                        ->group_by('scores.student_id')
                        ->join('challenge_classes','challenge_classes.challenge_id = scores.challenge_id')
                        ->where('challenge_classes.class_id',$class_id)
                        ->get('scores')->result_array();

        return $query;
    }


    public function registration_stats_monthly_teachers($data){
        $reg = $this->db
            ->select('*,MONTH(teachers.created) as MONTH, COUNT(teachers.user_id) AS NUMBER_OF_TEACHERS, MONTHNAME(teachers.created) as MONTH_NAME')
            ->group_by('MONTH')
            ->where('teachers.created >=',$data->from)
            ->where('teachers.created <=',$data->to)
            ->get('teachers')->result_array();
        return $reg;
    }
    public function registration_stats_monthly_students($data){
        $reg = $this->db
            ->select('*,MONTH(students.created) as MONTH, COUNT(students.user_id) AS NUMBER_OF_STUDENTS, MONTHNAME(students.created) as MONTH_NAME')
            ->group_by('MONTH')
            ->where('students.created >=',$data->from)
            ->where('students.created <=',$data->to)
            ->get('students')->result_array();

        return $reg;
    }

    public function registration_stats_weekly_teachers($data){
        $reg = $this->db
            ->select('*,MONTH(teachers.created) as MONTH, COUNT(teachers.user_id) AS NUMBER_OF_TEACHERS, MONTHNAME(teachers.created) as MONTH_NAME , WEEK(teachers.created) as WEEK')
            ->group_by('MONTH')
            ->where('teachers.created >=',$data->from)
            ->where('teachers.created <=',$data->to)
            ->get('teachers')->result_array();
        return $reg;
    }
    public function registration_stats_weekly_students($data){
        $reg = $this->db
            ->select('*,MONTH(students.created) as MONTH, COUNT(students.user_id) AS NUMBER_OF_STUDENTS, MONTHNAME(students.created) as MONTH_NAME , WEEK(students.created) as WEEK')
            ->group_by('MONTH')
            ->where('students.created >=',$data->from)
            ->where('students.created <=',$data->to)
            ->get('students')->result_array();

        return $reg;
    }

    public function registration_stats_day_teachers($data){
        $reg = $this->db
            ->select('*,MONTH(teachers.created) as MONTH, COUNT(teachers.user_id) AS NUMBER_OF_TEACHERS, MONTHNAME(teachers.created) as MONTH_NAME , WEEK(teachers.created) as WEEK, DAYOFYEAR(teachers.created) as DAY_NUMBER, DAYNAME(teachers.created) as DAY_NAME')
            ->group_by('MONTH')
            ->where('teachers.created >=',$data->from)
            ->where('teachers.created <=',$data->to)
            ->get('teachers')->result_array();
        return $reg;
    }
    public function registration_stats_day_students($data){
        $reg = $this->db
            ->select('*,MONTH(students.created) as MONTH, COUNT(students.user_id) AS NUMBER_OF_STUDENTS, MONTHNAME(students.created) as MONTH_NAME , WEEK(students.created) as WEEK, DAYOFYEAR(students.created) as DAY_NUMBER, DAYNAME(students.created) as DAY_NAME')
            ->group_by('MONTH')
            ->where('students.created >=',$data->from)
            ->where('students.created <=',$data->to)
            ->get('students')->result_array();

        return $reg;
    }
}