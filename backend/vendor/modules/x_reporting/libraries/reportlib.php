<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/10/13
 * Time: 10:54 AM
 * To change this template use File | Settings | File Templates.
 */
class Reportlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_reporting/report_model');
        $this->ci->load->helper('x_reporting/report');
        $this->ci->load->model('x_users/users_model');
        $this->ci->load->model('x_question/question_model');

        function sort_by_student_result($a, $b){
            return $b['result'] - $a['result'];
        }
        function sort_by_student_result_bottom($a, $b){
            return $a['result'] - $b['result'];
        }
        function sort_by_age($a, $b){
            return $a['age'] - $b['age'];
        }

        function sort_by_month($a,$b){
            return $a['MONTH'] - $b['MONTH'];
        }
    }

    /**
     * Function for getting top 3 students in class
     * @params: $class_id
     * @out: student list
     * */
    public function get_top_three_students_in_class($class_id){
        $challenge_list = $this->ci->report_model->get_challenges_by_class_id($class_id);
        $student_list = $this->ci->report_model->get_students_in_class($class_id);

        $students = array();

        foreach($challenge_list as $challenge=>$challenge_data){


                foreach($student_list as $student=>$student_data){
                    if($this->ci->report_model->is_challenge_student_in_score_table($challenge_data->getChallengeId(), $student_data->getPropStudent()->getStudentId()) === true){
                        $students[$student_data->getPropStudent()->getStudentId()]['name'] = $student_data->getPropStudent()->getPropUser()->getFirstName() . ' ' . $student_data->getPropStudent()->getPropUser()->getLastName();
                        $correct_incorrect = $this->get_student_classrooms_answers($challenge_data->getChallengeId(),$student_data->getPropStudent()->getStudentId());

                        if(isset($students[$student_data->getPropStudent()->getStudentId()]['number_of_question_in_challenge']) === true){
                            $students[$student_data->getPropStudent()->getStudentId()]['number_of_question_in_challenge'] += $correct_incorrect['correct'] + $correct_incorrect['incorrect'];
                        }else{
                            $students[$student_data->getPropStudent()->getStudentId()]['number_of_question_in_challenge'] = $correct_incorrect['correct'] + $correct_incorrect['incorrect'];
                        }
                        if(isset($students[$student_data->getPropStudent()->getStudentId()]['correct_questions']) === true){
                            $students[$student_data->getPropStudent()->getStudentId()]['correct_questions'] += $correct_incorrect['correct'];
                        }else{
                            $students[$student_data->getPropStudent()->getStudentId()]['correct_questions'] = $correct_incorrect['correct'];
                        }

                        if(isset($students[$student_data->getPropStudent()->getStudentId()]['incorrect']) === true){
                            $students[$student_data->getPropStudent()->getStudentId()]['incorrect'] += $correct_incorrect['incorrect'];
                        }else{
                            $students[$student_data->getPropStudent()->getStudentId()]['incorrect'] = $correct_incorrect['incorrect'];
                        }

                    }
                }

        }

        foreach($students as $student=>$student_data){
            if($student_data['number_of_question_in_challenge'] !== 0){
                $students[$student]['result'] = round(($student_data['correct_questions']/$student_data['number_of_question_in_challenge'])*100,2);
            }else{
                $students[$student]['result'] = 0;
            }

        }

        usort($students,'sort_by_student_result');
        $students = array_slice($students, 0, 3, true);

        return $students;

    }

    /**
     * Function for getting bottom 3 students in class
     * @params: $class_id
     * @out: student list
     * */
    public function get_bottom_three_students_in_class($class_id){
        $challenge_list = $this->ci->report_model->get_challenges_by_class_id($class_id);
        $student_list = $this->ci->report_model->get_students_in_class($class_id);

        $students = array();

        foreach($challenge_list as $challenge=>$challenge_data){


            foreach($student_list as $student=>$student_data){
                if($this->ci->report_model->is_challenge_student_in_score_table($challenge_data->getChallengeId(), $student_data->getPropStudent()->getStudentId()) === true){
                    $students[$student_data->getPropStudent()->getStudentId()]['name'] = $student_data->getPropStudent()->getPropUser()->getFirstName() . ' ' . $student_data->getPropStudent()->getPropUser()->getLastName();
                    $correct_incorrect = $this->get_student_classrooms_answers($challenge_data->getChallengeId(),$student_data->getPropStudent()->getStudentId());
                    if(isset($students[$student_data->getPropStudent()->getStudentId()]['number_of_question_in_challenge']) === true){
                        $students[$student_data->getPropStudent()->getStudentId()]['number_of_question_in_challenge'] += $correct_incorrect['correct'] + $correct_incorrect['incorrect'];
                    }else{
                        $students[$student_data->getPropStudent()->getStudentId()]['number_of_question_in_challenge'] = $correct_incorrect['correct'] + $correct_incorrect['incorrect'];
                    }
                    if(isset($students[$student_data->getPropStudent()->getStudentId()]['correct_questions']) === true){
                        $students[$student_data->getPropStudent()->getStudentId()]['correct_questions'] += $correct_incorrect['correct'];
                    }else{
                        $students[$student_data->getPropStudent()->getStudentId()]['correct_questions'] = $correct_incorrect['correct'];
                    }

                    if(isset($students[$student_data->getPropStudent()->getStudentId()]['incorrect']) === true){
                        $students[$student_data->getPropStudent()->getStudentId()]['incorrect'] += $correct_incorrect['incorrect'];
                    }else{
                        $students[$student_data->getPropStudent()->getStudentId()]['incorrect'] = $correct_incorrect['incorrect'];
                    }

                }
            }

        }

        foreach($students as $student=>$student_data){
            if($student_data['number_of_question_in_challenge'] !== 0){
                $students[$student]['result'] = round(($student_data['correct_questions']/$student_data['number_of_question_in_challenge'])*100,2);
            }else{
                $students[$student]['result'] = 0;
            }
        }

        usort($students,'sort_by_student_result_bottom');
        $students = array_slice($students, 0, 3, true);

        return $students;
    }

    /**
     * Function for calculating statistic for classes (page classes)
     * @params: $class_id
     * @out:    number in percent
     * @calculate_logic: (correct_answers / all_answers) * 100
     * */
    public function get_amount_statistic_correct_answers($class_id){
        $challenges         = $this->ci->report_model->get_challenge_list_by_class_and_teacher_id($class_id);
        $data               = new stdClass();
        $correct_answers    = 0;
        $all_answers  = 0;
        foreach($challenges as $challenge=>$val){
            $data->score[$challenge]['score_id'] = $val['score_id'];
            $answers = $this->get_number_of_answers_for_class($val['challenge_id'],$val['score_id']);

            $correct_answers    += $answers['correct'];
            $all_answers        += $answers['correct'] + $answers['incorrect'];
        }

       if($all_answers > 0){
           $stat_percent = round(($correct_answers / $all_answers) * 100,2);
       }else{
           $stat_percent = 0;
       }
        return $stat_percent;
    }


    public function get_number_of_answers_for_class($challenge_id, $score_id){

        $questions      = $this->ci->report_model->get_questions_by_challenge_id($challenge_id);
        $scores_answers = $this->ci->report_model->get_answers_from_score_answers_by_score_id($score_id);
        $questions_data = array();
        $correct_incorrect = array(
            'correct'   => 0,
            'incorrect' => 0
        );


        foreach($questions as $question=>$v){
            if (is_object($v->getPropQuestion()) === true) {
                $questions_data[$v->getQuestionId()]['question_text'] = $v->getPropQuestion()->getText();
                $questions_data[$v->getQuestionId()]['question_type'] = $v->getPropQuestion()->getType();
                $questions_data[$v->getQuestionId()]['question_correct_text'] = $v->getPropQuestion()->getCorrectText();
                $questions_data[$v->getQuestionId()]['question_correct_choice_id'] = $v->getPropQuestion()->getCorrectChoiceId();
            }
        }


        foreach($scores_answers as $answer=>$v){
            if($v['question_id'] != null){
                if(isset($questions_data[$v['question_id']]) === true){
                    switch($questions_data[$v['question_id']]['question_type']){
                        case 'calculator' :
                            if(@$v['correct_text'] === $questions_data[$v['question_id']]['question_correct_text'] ){
                                $correct_incorrect['correct'] += 1;
                            }else{
                                $correct_incorrect['incorrect'] += 1;
                            }
                            break;
                        case 'multiple_choice' :
                            if(intval($v['choice_id']) === $questions_data[$v['question_id']]['question_correct_choice_id']){
                                $correct_incorrect['correct'] += 1;
                            }else{
                                $correct_incorrect['incorrect'] += 1;
                            }
                            break;
                        case 'order_slider' :
                            $correct_order  = explode(',',$questions_data[$v['question_id']]['question_correct_text']);
                            $check_order    = explode(',',$v['text']);

                            $correct = false;
                            foreach($correct_order as $k=>$v){
                                if(intval($v) === intval($check_order[$k])){
                                    $correct = true;
                                }else{
                                    $correct = false;
                                    break;
                                }
                            }

                            if($correct === true){
                                $correct_incorrect['correct'] += 1;
                            }else{
                                $correct_incorrect['incorrect'] += 1;
                            }
                            break;
                    }
                }
            }
        }

        return $correct_incorrect;
    }

    /**
     * Function for getting correct and incorrect answers
     * @params: challenge_id
     * @out:    list with number of correct and incorrect answer's
     * */
    public function get_student_classrooms_answers($challenge_id, $student_id){

        $questions      = $this->ci->report_model->get_questions_by_challenge_id($challenge_id);
        $scores_answers = $this->ci->report_model->get_answers_from_score_answers($challenge_id,$student_id);
        $questions_data = array();
        $correct_incorrect = array(
            'correct'   => 0,
            'incorrect' => 0
        );


        foreach($questions as $question=>$v){
            if (is_object($v->getPropQuestion()) === true) {
                $questions_data[$v->getQuestionId()]['question_text'] = $v->getPropQuestion()->getText();
                $questions_data[$v->getQuestionId()]['question_type'] = $v->getPropQuestion()->getType();
                $questions_data[$v->getQuestionId()]['question_correct_text'] = $v->getPropQuestion()->getCorrectText();
                $questions_data[$v->getQuestionId()]['question_correct_choice_id'] = $v->getPropQuestion()->getCorrectChoiceId();
            }
        }

        foreach($scores_answers as $answer=>$v){
            if($v['question_id'] != null && isset($questions_data[$v['question_id']]) === true){
                switch($questions_data[$v['question_id']]['question_type']){
                    case 'calculator' :
                        if(@strcmp(strtolower($v['text']),strtolower($questions_data[$v['question_id']]['question_correct_text'])) === 0  ){
                            $correct_incorrect['correct'] += 1;
                        }else{
                            $correct_incorrect['incorrect'] += 1;
                        }
                        break;
                    case 'multiple_choice' :
                        if(intval($v['choice_id']) === $questions_data[$v['question_id']]['question_correct_choice_id']){
                            $correct_incorrect['correct'] += 1;
                        }else{
                            $correct_incorrect['incorrect'] += 1;
                        }
                        break;
                    case 'order_slider' :
                        $correct_order  = explode(',',$questions_data[$v['question_id']]['question_correct_text']);
                        $check_order    = explode(',',$v['text']);

                        $correct = false;
                        foreach($correct_order as $k=>$v){
                            if(intval($v) === intval($check_order[$k])){
                                $correct = true;
                            }else{
                                $correct = false;
                                break;
                            }
                        }

                        if($correct === true){
                            $correct_incorrect['correct'] += 1;
                        }else{
                            $correct_incorrect['incorrect'] += 1;
                        }
                        break;
                }

            }
        }

        return $correct_incorrect;
    }


    /**
     * Function to check if answer is correct
     * @params: Propel Question Object, Propel Answer Object
     * @out: 1 if answer is correct or 0 if answer is incorrect
     * */
    public function check_question_correct( $question, $answer ){
        switch($question->getType()){
            case 'calculator' :
                if(@strcmp(strtolower($question->getCorrectText()),strtolower($answer->getText())) === 0  ){
                    return 1;
                }else{
                    return 0;
                }
                break;
            case 'multiple_choice' :
                if(intval($question->getCorrectChoiceId()) === $answer->getChoiceId()){
                    return 1;
                }else{
                    return 0;
                }
                break;
            case 'order_slider' :
                $correct_order  = explode(',',$question->getCorrectText());
                $check_order    = explode(',',$answer->getText());

                $correct = false;
                foreach($correct_order as $k=>$v){
                    if(intval($v) === intval($check_order[$k])){
                        $correct = true;
                    }else{
                        $correct = false;
                        break;
                    }
                }

                if($correct === true){
                    return 1;
                }else{
                    return 0;
                }
                break;
        }
    }

    /**
     * Function for getting top 3 students
     * @out:    array of students
     *  OLD FUNCTION - BAD
     */
    public function get_top_three_students(){
        $students_list = $this->ci->report_model->get_students_with_scores();

        /** format students list for getting correct incorrect answers
         *  array(
         *     student_id = array(
         *          challenge_id = array(correct, incorrect)
         *     )
         * )
         *
         * */

        $students = array();
        foreach($students_list as $student=>$val){
            $students[$val->getStudentId()]['name'] = $this->ci->users_model->get_student_name($val->getStudentId());
            $score_answers = $this->ci->report_model->get_student_score_answers($val->getScoreId());

            if(isset($students[$val->getStudentId()]['number_of_question_in_challenge']) === false){
                $students[$val->getStudentId()]['number_of_question_in_challenge'] = 0;
            }else {
                $students[$val->getStudentId()]['number_of_question_in_challenge'] += $val->getPropChallenge()->getPropChallengeQuestions()->count();
            }

            foreach($score_answers as $answer=>$answer_data){
                $correct_question = $this->ci->report_model->get_correct_question_answer($answer_data->getQuestionId());

                $score = $this->check_question_correct($correct_question,$answer_data);
                if($score === 1){
                    if(isset($students[$val->getStudentId()]['correct_questions']) === false) {
                        $students[$val->getStudentId()]['correct_questions'] = 0;
                    }
                        $students[$val->getStudentId()]['correct_questions'] = $students[$val->getStudentId()]['correct_questions'] + 1;
                }
                else{
                    if(isset($students[$val->getStudentId()]['incorrect_questions'])=== false) $students[$val->getStudentId()]['incorrect_questions'] = 0;
                        $students[$val->getStudentId()]['incorrect_questions'] = $students[$val->getStudentId()]['incorrect_questions'] + 1;
                }

            }

        }

        foreach($students as $student=>$student_data){
            $students[$student]['result'] = round(($student_data['correct_questions']/$student_data['number_of_question_in_challenge'])*100,2);
        }

        usort($students,'sort_by_student_result');
        $students = array_slice($students, 0, 3, true);

        return $students;
    }


    /**
     * Function for getting correct and incorrect answers by score id
     * */
    public function get_answer_data_by_score_id($score_id){

        $data = array(
            'correct' => 0,
            'incorrect' => 0
        );
        $answers_data = $this->ci->report_model->get_score_answers_data_by_score_id($score_id);
        if($answers_data->getFirst() !== null){
            foreach($answers_data as $answer=>$val){
                $question_data = $this->ci->question_model->get_question_by_id($val->getQuestionId());
                $answer_data = $answers_data[$answer];

                $correct_answer = $this->check_question_correct($question_data, $answer_data);

                if($correct_answer === 1){
                    $data['correct']++;
                }
                if($correct_answer === 0){
                    $data['incorrect'] ++;
                }
            }

            return $data;
        }else{
            return $data;
        }


    }


    /**
     *  Function for getting average students result for challange
     *  @params: challenge_id, student_id
     *  @out: result - number - in correct percent
     * */

    public function get_students_average_result_for_teacher_challenge($challenge_id, $student_id){
        $correct_incorrect = $this->get_student_classrooms_answers($challenge_id, $student_id);

//        $number_of_question = $this->ci->question_model->count_questions_in_challenge($challenge_id);
        $number_of_question = $correct_incorrect['correct'] + $correct_incorrect['incorrect'];
        if(intval($number_of_question) !== 0){
            $percent = round(($correct_incorrect['correct']/$number_of_question)*100,2);
        }else{
            $percent = 0;
        }

        return $percent;
    }

    public function get_school_average_result_for_teacher_challenges($challenge_id){

        // get list of students who played this challenge in teacher school

        $classes = $this->ci->report_model->get_challenge_classes_with_challenge_teacher_school($challenge_id);
//        $number_of_question_in_challenge = $this->ci->question_model->count_questions_in_challenge($challenge_id);
        $number_of_question_in_challenge = 0;

        $class_id_list = array();
        foreach($classes as $class=>$val){
            $class_id_list[] = $val->getClassId();
        }

        $students = $this->ci->report_model->get_students_by_class_id($class_id_list);

        $number_of_students_who_payed_challenge = 0;
        $amount_correct_answers = 0;
        // hack
        $calculated_data_for_student = array();
        foreach($students as $key=>$val){
            // check if student played this challenge

            if(in_array( $val->getStudentId(), $calculated_data_for_student) === false ){

                $calculated_data_for_student[] = $val->getStudentId();

                $score_data = $this->ci->report_model->get_score_data_by_challenge_array_student_id($challenge_id, $val->getStudentId());

                if($score_data->getFirst() != null){
                    $number_of_students_who_payed_challenge ++;
                    $correct_incorrect = $this->get_student_classrooms_answers($challenge_id, $val->getStudentId());
                    $number_of_question_in_challenge += $correct_incorrect['correct'] + $correct_incorrect['incorrect'];
                    $amount_correct_answers += $correct_incorrect['correct'];

                }
            }

        }
        if($number_of_question_in_challenge > 0 && $number_of_students_who_payed_challenge > 0){
            $result_percent = round(($amount_correct_answers/($number_of_question_in_challenge * $number_of_students_who_payed_challenge))*100,2);
        }else{
            $result_percent = 0;
        }

        return $result_percent;
    }

    public function get_state_average_result_for_teacher_challenges($challenge_id){

        // get list of students who played this challenge in teacher school

        $classes = $this->ci->report_model->get_challenge_classes_with_challenge_teacher_state($challenge_id);
//        $number_of_question_in_challenge = $this->ci->question_model->count_questions_in_challenge($challenge_id);
        $number_of_question_in_challenge = 0;
        $class_id_list = array();
        foreach($classes as $class=>$val){
            $class_id_list[] = $val->getClassId();
        }

        $students = $this->ci->report_model->get_students_by_class_id($class_id_list);

        $number_of_students_who_payed_challenge = 0;
        $amount_correct_answers = 0;
        // hack
        $calculated_data_for_student = array();

        foreach($students as $key=>$val){
            // check if student played this challenge
            if(in_array( $val->getStudentId(), $calculated_data_for_student) === false ){

                    $score_data = $this->ci->report_model->get_score_data_by_challenge_array_student_id($challenge_id, $val->getStudentId());

                if($score_data->getFirst() != null){
                    $number_of_students_who_payed_challenge ++;
                    $correct_incorrect = $this->get_student_classrooms_answers($challenge_id, $val->getStudentId());
                    $number_of_question_in_challenge += $correct_incorrect['correct'] + $correct_incorrect['incorrect'];
                    $amount_correct_answers += $correct_incorrect['correct'];
                }
            }
        }
        if($number_of_question_in_challenge > 0 && $number_of_students_who_payed_challenge > 0 ){
            $result_percent = round(($amount_correct_answers/($number_of_question_in_challenge * $number_of_students_who_payed_challenge))*100,2);
        }else{
            $result_percent = 0;
        }

        return $result_percent;
    }

    /** function for calculating coins for specific challenge by score log */

    public function get_student_coins_for_challenge($created_date, $student_id, $challenge_id){
        $shop_transactions = $this->ci->report_model->get_student_coins_by_score_log($created_date, $student_id, $challenge_id);


        $coins_num = 0;

        if($shop_transactions->getFirst() !== null){
            foreach($shop_transactions as $key=>$transaction){
                $coins_num += intval($transaction->getNumCoins());
            }
        }


        return $coins_num;
    }

    /** Function for getting student age statistic
     *
     */
    public function student_age_statistic(){

        $student_list = $this->ci->users_model->getList();

        $students = array();
        foreach($student_list as $student=>$val){
            $students[$val->getUserId()]['name'] = $val->getFirstName() . ' ' . $val->getLastName();

            if($val->getPropStudent()->getDob() !== null){
                $birthDate = new DateTime( $val->getPropStudent()->getDob());
                $now = new DateTime();

                $interval = $now->diff($birthDate);
                $students[$val->getUserId()]['age'] = $interval->y;
            }else{
                $students[$val->getUserId()]['age'] = 0;
            }
        }

        usort($students,'sort_by_age');
        return $students;
    }

    /**
     *  Function for getting registration statistic
     */

    public function registration_stats_monthly($data){

        $start_month = date_parse_from_format("Y/m/d",$data->from);
        $end_month   = date_parse_from_format("Y/m/d",$data->to);

        $reg_teacher  = $this->ci->report_model->registration_stats_monthly_teachers($data);
        $reg_students = $this->ci->report_model->registration_stats_monthly_students($data);


        $formatted_data = array();
        $formatted_data[0] = array('MONTH','TEACHER','STUDENT');

        for($i = $start_month['month']; $i <= $end_month['month']; $i++){
            $added_student = false;
            $added_teacher = false;
            $month_number = mktime(0, 0, 0, $i);
            $month_name = strftime("%b", $month_number);

            $tmp_arr[] = $month_name;


            foreach($reg_teacher as $teacher=>$teacher_val){
                if(intval($teacher_val['MONTH']) === $i){
                    $tmp_arr[] = intval($teacher_val['NUMBER_OF_TEACHERS']);
                    $added_teacher = true;
                }
            }

            if($added_teacher === false){
                $tmp_arr[] = 0;
            }

            foreach($reg_students as $student=>$student_val){
                if(intval($student_val['MONTH']) === $i){
                    if(isset($student_val['NUMBER_OF_STUDENTS'])){
                        $tmp_arr[] = intval($student_val['NUMBER_OF_STUDENTS']);
                        $added_student = true;
                    }
                }
            }

            if($added_student === false){
                $tmp_arr[] = 0;
            }

            $formatted_data[] = $tmp_arr;
            unset($tmp_arr);
        }

        return $formatted_data;
    }

    public function registration_stats_weekly($data){
        $reg_teacher  = $this->ci->report_model->registration_stats_weekly_teachers($data);
        $reg_students = $this->ci->report_model->registration_stats_weekly_students($data);


        $min_week = ( intval($reg_students[0]['WEEK']) < intval($reg_teacher[0]['WEEK']) ) ? intval($reg_students[0]['WEEK']) :intval($reg_teacher[0]['WEEK']);
        $max_week = ( intval($reg_students[0]['WEEK']) > intval($reg_teacher[0]['WEEK']) ) ? intval($reg_students[0]['WEEK']) :intval($reg_teacher[0]['WEEK']);


        $formatted_data = array();
        $formatted_data[0] = array('WEEK','TEACHER','STUDENT');

        for($i = $min_week; $i <= $max_week; $i++){
            $added_student = false;
            $added_teacher = false;

            $tmp_arr[] = $i;


            foreach($reg_teacher as $teacher=>$teacher_val){
                if(intval($teacher_val['WEEK']) === $i){
                    $tmp_arr[] = intval($teacher_val['NUMBER_OF_TEACHERS']);
                    $added_teacher = true;
                }
            }

            if($added_teacher === false){
                $tmp_arr[] = 0;
            }

            foreach($reg_students as $student=>$student_val){
                if(intval($student_val['WEEK']) === $i){
                    if(isset($student_val['NUMBER_OF_STUDENTS'])){
                        $tmp_arr[] = intval($student_val['NUMBER_OF_STUDENTS']);
                        $added_student = true;
                    }
                }
            }

            if($added_student === false){
                $tmp_arr[] = 0;
            }

            $formatted_data[] = $tmp_arr;
            unset($tmp_arr);
        }

        return $formatted_data;
    }

    public function registration_stats_daily($data){
        $reg_teacher  = $this->ci->report_model->registration_stats_day_teachers($data);
        $reg_students = $this->ci->report_model->registration_stats_day_students($data);


        $min_day = ( intval($reg_students[0]['DAY_NUMBER']) < intval($reg_teacher[0]['DAY_NUMBER']) ) ? intval($reg_students[0]['DAY_NUMBER']) :intval($reg_teacher[0]['DAY_NUMBER']);
        $max_day = ( intval($reg_students[0]['DAY_NUMBER']) > intval($reg_teacher[0]['DAY_NUMBER']) ) ? intval($reg_students[0]['DAY_NUMBER']) :intval($reg_teacher[0]['DAY_NUMBER']);


        $formatted_data = array();
        $formatted_data[0] = array('DAY','TEACHER','STUDENT');

        for($i = $min_day; $i <= $max_day; $i++){
            $added_student = false;
            $added_teacher = false;

            $tmp_arr[] = $this->dayofyear2date($i,'m/d/Y');


            foreach($reg_teacher as $teacher=>$teacher_val){
                if(intval($teacher_val['DAY_NUMBER']) === $i){
                    $tmp_arr[] = intval($teacher_val['NUMBER_OF_TEACHERS']);
                    $added_teacher = true;
                }
            }

            if($added_teacher === false){
                $tmp_arr[] = 0;
            }

            foreach($reg_students as $student=>$student_val){
                if(intval($student_val['DAY_NUMBER']) === $i){
                    if(isset($student_val['NUMBER_OF_STUDENTS'])){
                        $tmp_arr[] = intval($student_val['NUMBER_OF_STUDENTS']);
                        $added_student = true;
                    }
                }
            }

            if($added_student === false){
                $tmp_arr[] = 0;
            }

            $formatted_data[] = $tmp_arr;
            unset($tmp_arr);
        }

        return $formatted_data;
    }


    /**
     * function for creating table for student statistic
     * @params: $data
     * @out:    html
     * */
    public function get_table_student_statistic($data){
        ob_start();
        ?>
        <table id="class_student_stats_table"
               class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
            <thead>
            <tr role="row">
                <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Challenge Name</th>
                <th style="width: 305px;" class="sorting" rowspan="1" colspan="1">Correct Answers</th>
                <th style="width: 242px;" class="sorting" rowspan="1" colspan="1">Incorrect Answers</th>
                <th class="hidden-phone sorting" style="width: 242px;" rowspan="1" colspan="1">Time on Course</th>
                <th class="hidden-phone sorting_desc" style="width: 242px;" rowspan="1" colspan="1">Coins Collected</th>
            </tr>
            </thead>
            <tbody id="class_student_stats_tbody">
            <?php foreach ($data as $k => $v): ?>
                <tr class="gradeA info odd">
                    <td><?php echo $v['challenge_name']?></td>
                    <td><?php echo $v['correct_answers']?></td>
                    <td><?php echo $v['incorrect_answers']?></td>
                    <td class="hidden-phone"><?php echo $v['total_duration']?></td>
                    <td class="hidden-phone sorting_1"><?php echo $v['coins_collected']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php
        $out =  ob_get_clean();
        return $out;
    }

    /**
     * Function for creating table for student statistic played challenges
     * @params: data
     * @out:    html
     * */
    public function get_table_student_statistic_played_challenges($data){
        ob_start();
        ?>
        <table id="student_stats_table"
               class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
            <thead>
            <tr role="row" class="thead">
                <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">First name</th>
                <th style="width: 305px;" class="sorting" rowspan="1" colspan="1">Last name</th>
                <th style="width: 242px;" class="sorting" rowspan="1" colspan="1">Played challenges</th>
            </tr>
            </thead>
            <tbody id="student_stats_table_tbody">
            <?php foreach ($data as $k => $v): ?>
                <tr class="gradeA info odd" data-student="<?php echo $v['student_id'] ?>">
                    <td class=""><?php echo $v['student_firstname']?></td>
                    <td class=""><?php echo $v['student_lastname']?></td>
                    <td class=""><?php echo $v['number_of_challenges']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php
        $out =  ob_get_clean();
        return $out;
    }

    public function get_table_student_statistic_details($data){
        ob_start();
        ?>
        <table id="student_stats_details_table"
               class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
            <thead>
            <tr role="row">
                <th style="width: 242px;" class="sorting" rowspan="1" colspan="1">Challenge name</th>
                <th style="width: 242px;" class="sorting" rowspan="1" colspan="1">Played times</th>
            </tr>
            </thead>
            <tbody id="student_stats_details_table_tbody">
            <?php foreach ($data as $k => $v): ?>
                <tr class="gradeA info odd">
                    <td class=""><?php echo $v['challenge_name']?></td>
                    <td class=""><?php echo $v['number_of_played_times']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php
        $out =  ob_get_clean();
        return $out;
    }

    /**
     * function for creating table for student statistic
     * @params: $data
     * @out:    html
     * */
    public function get_table_student_statistic_individually_challenge($data){
        ob_start();
        ?>
        <table id="class_student_stats_table"
               class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
            <thead>
            <tr role="row">
                <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Date</th>
                <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Challenge Name</th>
                <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Percentage</th>
                <th style="width: 305px;" class="sorting" rowspan="1" colspan="1">Correct Answers</th>
                <th style="width: 242px;" class="sorting" rowspan="1" colspan="1">Incorrect Answers</th>
                <th class="hidden-phone sorting" style="width: 242px;" rowspan="1" colspan="1">Time on Course</th>
                <th class="hidden-phone sorting_desc" style="width: 242px;" rowspan="1" colspan="1">Coins Collected</th>
            </tr>
            </thead>
            <tbody id="class_student_stats_tbody">
            <?php foreach ($data as $k => $v): ?>
                <tr class="gradeA info odd">
                    <td><?php echo $v['date']?></td>
                    <td><?php echo $v['challenge_name']?></td>
                    <td><?php echo $v['percentage']?></td>
                    <td><?php echo $v['correct_answers']?></td>
                    <td><?php echo $v['incorrect_answers']?></td>
                    <td class="hidden-phone"><?php echo $v['time_on_course']?></td>
                    <td class="hidden-phone sorting_1"><?php echo $v['coins_collected']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php
        $out =  ob_get_clean();
        return $out;
    }

    /** Function to calculate date by date id in year */
    private function dayofyear2date( $tDay, $tFormat = 'd-m-Y' ) {
        $day = intval( $tDay );
        $day = ( $day == 0 ) ? $day : $day - 1;
        $offset = intval( intval( $tDay ) * 86400 );
        $str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
        return( $str );
    }

}