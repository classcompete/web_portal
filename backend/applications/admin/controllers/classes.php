<?php

class Classes extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('x_class/classlib');
        $this->load->library('propellib');

        $this->load->library('form_validation');

        $this->propellib->load_object('Clas');
        $this->mapperlib->set_model($this->class_model);

        $this->mapperlib->add_column('name', ' Class name', true);
        $this->mapperlib->add_column('auth_code', 'Auth code', true);
        $this->mapperlib->add_column('teacher_first_name', 'Teacher first name', false);
        $this->mapperlib->add_column('teacher_last_name', 'Teacher last name', false);
        $this->mapperlib->add_column('price','Price',true);
        $this->mapperlib->add_column('limit','Limit',false);

        $this->mapperlib->add_option('class_student', array(
            'title' => array(
                'base' => 'Student in class',
                'field' => 'name',
            ),
            'uri' => 'users/students_pc',
            'params' => array(
                'id',
            ),
            'data-target' => '',
            'data-toggle' => ''
        ));
        $this->mapperlib->add_option('admin_students_in_class_stats_accordion', array(
            'title' => array(
                'base' => 'Class statistic',
                'field' => 'name',
            ),
            'uri' => '#',
            'params' => array(
                'id',
            ),
            'data-target' => '#adminClassStatistic',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_option('admin_class_stats_average_month_accordion', array(
            'title' => array(
                'base' => 'Average Class Scores by Month',
                'field' => 'name',
            ),
            'uri' => '#',
            'params' => array(
                'id',
            ),
            'data-target' => '#adminClassStatsAverageMonth',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_option('admin_class_stats_increase_month_accordion', array(
            'title' => array(
                'base' => 'Class Scores Increase by Month',
                'field' => 'name',
            ),
            'uri' => '#',
            'params' => array(
                'id',
            ),
            'data-target' => '#adminClassStatsIncreaseMonth',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name',
            ),
            'uri' => '#classes/edit',
            'params' => array(
                'id',
            ),
            'data-target' => '#addEditClass',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_option('delete', array(
            'title' => array(
                'base' => 'Delete',
                'field' => 'name',
            ),
            'uri' => 'classes/delete_class',
            'params' => array(
                'id',
            ),
            'data-target' => '',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_order_by('name', 'Name');
        $this->mapperlib->add_order_by('auth_code', 'Auth code');
        $this->mapperlib->add_order_by('price','Price');
        $this->mapperlib->add_order_by('limit','Limit');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);

        $this->mapperlib->set_default_order(PropClasPeer::NAME, Criteria::ASC);

    }

    public function index($user_id = null)
    {
        if (intval($user_id) > 0) {
            $this->mapperlib->set_breaking_segment(4);
            $this->mapperlib->set_default_base_page('classes/index/' . $user_id);
            $teacherUri = $user_id . '/';
        } else {
            $this->mapperlib->set_breaking_segment(3);
            $this->mapperlib->set_default_base_page('classes/index');
            $teacherUri = null;
        }
        $this->load->model('x_users/teacher_model');
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {

            redirect('classes/index/' . $teacherUri . $uri);
        }

        $data = new stdClass();
        $teacher__data = $this->teacher_model->get_teacher_info($user_id);
        if (empty($user_id) === false && empty($teacher__data) === false) {
            $this->class_model->filterByTeacherUserId($user_id);
        }

        $data->table = $this->mapperlib->generate_table(true);

        $data->count_classes = $this->class_model->getFoundRows();

        $data->content = $this->prepareView('x_class', 'home', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function edit($id)
    {
        $class = $this->class_model->get_class_by_id($id);
        $this->class_form($class);
    }

    public function add_new()
    {
        $this->class_form(null, true);
    }

    public function class_form(PropClas $class = null, $add_new = false)
    {
        $data = new stdClass();
        if (is_object($class)) {
            $_POST = array(
                'name' => $class->getName(),
                'auth_code' => $class->getAuthCode()
            );
            $flashdata = $this->session->flashdata('admin-' . $class->getId());
            if (empty($flashdata) === false) {
                $_POST = array_merge($_POST, $flashdata);
            }
        } else {
            $_POST = $this->session->flashdata('admin-');
        }


        $teachers = $this->class_model->get_teachers();
        $teachers_array = array();
        foreach ($teachers as $k => $teacher) {
            $teachers_array[$k]['user_id'] = $teacher->getUserId();
            $teachers_array[$k]['login'] = $teacher->getLogin();
        }
        if ($add_new == false) {
            $teacher_user_id = $this->class_model->get_teacher_user_id_by_teacher_id($class->getTeacherId());
            $data->teacher_user_id = $teacher_user_id->getUserId();
        } else {
            $data->teacher_user_id = null;
        }

        $data->class = $class;
        $data->add_new = $add_new;
        $data->teachers = $teachers_array;

        $data->content = $this->prepareView('x_class', 'form', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function save(){

        $class_id = $this->input->post('class_id');

        if ($this->form_validation->run('classes') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $class_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $class_data = new stdClass();

        $class_data->name = $this->input->post('name');
        $class_data->user_id = $this->input->post('user_id');
        $class_data->auth_code = $this->input->post('class_code');
        $class_data->price = floatval($this->input->post('price'));
        $class_data->limit = intval($this->input->post('limit'));

        $this->class_model->save($class_data, $class_id);
        redirect('classes');

    }

    /*
    * validation function for save function
    * */

    public function ajax_validation(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('classes') === false){
            if(form_error('name') != '')
                $error['name'] = form_error('name');
            if(form_error('class_code') != '')
                $error['class_code'] = form_error('class_code');
            if(form_error('user_id') != '')
                $error['user_id'] = form_error('user_id');

            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));

    }

    public function delete_class($class_id){

        $error = array();

        try {
            $this->class_model->delete_class($class_id);
            $error['passed'] = true;
        }catch (Exception $e){
            $error['error'] = $e->getMessage();
            $this->output->set_status_header(400);
        }

        $this->output->set_output(json_encode($error));
    }

    public function ajax($id)
    {
        $class = $this->class_model->get_class_by_id($id);

        if (empty($class) === false) {
            $teacher_id = $class->getTeacherId();
            $user = $this->class_model->get_teacher_user_id_by_teacher_id($teacher_id);

            $output = new stdClass();
            $output->id = $class->getClassId();
            $output->user_id = $user->getUserId();
            $output->teacher_id = $teacher_id;
            $output->name = $class->getName();
            $output->auth_code = $class->getAuthCode();
            $output->price = $class->getPrice();
            $output->limit = $class->getLimit();

            $this->output->set_output(json_encode($output));
        }
    }

    public function ajax_teachers()
    {
        $teachers = $this->class_model->get_teachers();

        $teachers_array = array();
        foreach ($teachers as $k => $teacher) {
            $teachers_array[$k]['user_id'] = $teacher->getUserId();
            $teachers_array[$k]['login'] = $teacher->getLogin();
            $teachers_array[$k]['first_name'] = $teacher->getFirstName();
            $teachers_array[$k]['last_name'] = $teacher->getLastName();
            $teachers_array[$k]['email'] = $teacher->getEmail();
            $teachers_array[$k]['created'] = $teacher->getCreated();
            $teachers_array[$k]['modified'] = $teacher->getModified();
        }

        $this->output->set_output(json_encode($teachers_array));
    }

    public function teachers()
    {
        $this->mapperlib->set_default_base_page('classes/index');
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('classes/teachers/' . $uri);
        }

        $this->mapperlib->remove_column('name');
        $this->mapperlib->remove_column('auth_code');
        $this->mapperlib->add_column('teacher_first_name', 'Teacher first name');
        $this->mapperlib->add_column('teacher_last_name', 'Teacher last name');
        $this->mapperlib->add_column('name', 'Name', true);
        $this->mapperlib->add_column('auth_code', 'Auth code', true);

        $data = new stdClass();

        $this->class_model->get_teachers();
        $data->table = $this->mapperlib->generate_table(true);

        $data->content = $this->prepareView('x_class', 'home_teachers', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function ajax_class_code(){
        $code_status = true;
        while($code_status){
            $code = $this->classlib->generatePassword();
            $code_status = $this->class_model->check_class_code($code);
        }


        $this->output->set_output(json_encode($code));
    }

    /*
     * get profile of specific student
     * @params: user_id
     * @output: student data
     * */
    public function ajax_get_student_profile(){
        $user_id = $this->input->post('user_id');

        $out = array();

        $student_data = $this->class_model->get_student_profile($user_id);

        $out['user_id'] = $student_data->getPropUser()->getUserId();
        $out['username'] = $student_data->getPropUser()->getLogin();
        $out['first_name'] = $student_data->getPropUser()->getFirstName();
        $out['last_name'] = $student_data->getPropUser()->getLastName();
        $out['student_dob'] = $student_data->getDob();
        $out['student_email'] = $student_data->getPropUser()->getEmail();

        $out['parent_email'] = ($student_data->getPropUser()->getPropStudent()->getParentEmail() !== null)?$student_data->getPropUser()->getPropStudent()->getParentEmail():'false';

        $this->output->set_output(json_encode($out));
    }

    /*
     * function to display student image
     * @params: user_id of student
     * @output: image
     * */
    public function display_student_image($user_id = false){
        $content = null;
        if($user_id){
            $image = $this->class_model->get_student_image($user_id);

            $this->output->set_header('Content-type: image/png');

            if($image['avatar_thumbnail'] === null){
                $fp = fopen(X_IMAGES_PATH .'/'.'profile.png','r');
                $image['avatar_thumbnail'] = fread($fp,filesize(X_IMAGES_PATH .'/'.'profile.png'));
            }
            $this->output->set_output($image['avatar_thumbnail']);
        }
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
            $data[$score]['date'] = date('m/d/Y h:i a', strtotime($score_val->getCreated()) - (5*60*60));
            $data[$score]['challenge_name'] = $score_val->getPropChallenge()->getName();
            $data[$score]['percentage'] = $score_val->getScoreAverage();
            $data[$score]['correct_answers'] = $score_val->getNumCorrectQuestions();
            $data[$score]['incorrect_answers'] = $score_val->getNumTotalQuestions() - $score_val->getNumCorrectQuestions();
            $data[$score]['time_on_course'] = $score_val->getTotalDuration();
//            $data[$score]['coins_collected']    = $this->reportlib->get_student_coins_for_challenge($score_val->getCreated(),$student_id,$score_val->getChallengeId());
        }

        $out = $this->reportnewlib->get_table_student_statistic_individually_challenge($data);

        $this->output->set_output($out);
    }
}