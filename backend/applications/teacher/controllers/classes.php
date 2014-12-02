<?php

class Classes extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('x_class/classlib');
        $this->load->library('propellib');
        $this->load->library('form_validation');
        $this->load->model('x_class_student/class_student_model');
        $this->load->model('x_users/users_model');
        $this->load->library('x_reporting/reportlib');
        $this->load->library('x_reporting_new/reportnewlib');

        /*$this->propellib->load_object('Clas');
        $this->propellib->load_object('Challenge');
        $this->mapperlib->set_model($this->class_model);

        $this->mapperlib->add_column('teacher_first_name', 'Teacher first name', false);
        $this->mapperlib->add_column('teacher_last_name', 'Teacher last name', false);
        $this->mapperlib->add_column('name', 'Name', true);
        $this->mapperlib->add_column('auth_code', 'Auth code', true);

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

        $this->mapperlib->add_order_by('name', 'Name');
        $this->mapperlib->add_order_by('auth_code', 'Auth code');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);

        $this->mapperlib->set_default_order(PropClasPeer::NAME, Criteria::ASC);*/

    }

    public function index()
    {
        /*
         * get teacher id for filtering
         * */
        $teacher_id = TeacherHelper::getId();

        $data = new stdClass();

        if (empty($teacher_id) === false) {
            $this->class_model->filterByTeacherId($teacher_id);
        }

        $class_list = $this->class_model->getList();
        $data->class_list = array();
        if (empty($class_list) === false) {
            foreach ($class_list as $k => $v) {
                $data->class_list[$k]['class_id'] = $v->getClassId();
                $data->class_list[$k]['class_name'] = $v->getName();
                $data->class_list[$k]['licenses_text'] = $v->getLimit() . ' licenses ';
            }
        }

        $class_statistic = $this->class_model->getList();

        if(empty($class_statistic) === false){
            foreach($class_statistic as $class=>$val){
                $data->class_statistic[$class]['class_name'] = $val->getName();
                $average = $this->reportnew_model->get_amount_statistic_for_specific_class($val->getClassId());
                if($average === null)$average = 0;
                $data->class_statistic[$class]['class_statistic'] = round($average,2);
            }
        }
        $data->content = $this->prepareView('x_class', 'home_teachers', $data);
        $this->load->view(config_item('teacher_template'), $data);
    }

    public function save(){

        $class_id = $this->input->post('class_id');
        if ($this->form_validation->run('classes') === false) {
            $error = $this->form_validation->error_string('<span>', '<span>');
            $this->notificationlib->set($error, Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $class_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $code = $this->input->post('class_code');

        if(isset($class_id) === true && empty($class_id) === false){
            $check = $this->class_model->check_edit_class_code($code, $class_id);
        }else{
            $check = $this->class_model->check_class_code($code);
        }


        if($check === true){
            redirect();
        }

        $class_data = new stdClass();

        $class_data->name = $this->input->post('name');
        $class_data->user_id = TeacherHelper::getUserId();
        $class_data->auth_code = $this->input->post('class_code');
        $class_data->limit = $this->input->post('licenses');
        if (empty($class_data->limit) === true) {
            $class_data->limit = 2;
        }
        $redirect = $_SERVER['HTTP_REFERER'];
        if (empty($class_id) === true) {
            $redirect = 'marketplace';
        }


        $class = $this->class_model->save($class_data, $class_id);
        redirect($redirect);

    }

    /*
     * save function for add new student to class
     * */
    public function save_student(){

        $class_student_id = $this->input->post('class_student_id');

        if ($this->form_validation->run('class_student') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $class_student_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }


        $classStudentData = new stdClass();
        $classStudentData->class_id = $this->input->post('class_id');
        $classStudentData->user_id = $this->input->post('user_id');


        $student = $this->class_student_model->save($classStudentData, $class_student_id);

        if(empty($student) === false){
            $data = array(
                'passed' => true
            );
            $this->output->set_output(json_encode($data));
        }
    }

    /*
     * validation for add new or edit class
     * */
    public function ajax_validation(){

        $error = array();

        $licenses = $this->input->post('licenses');
        $code = $this->input->post('class_code');
        $class_id = $this->input->post('class_id');

        $class = PropClasQuery::create()->findOneByClassId($class_id);

        $studentsInClass = PropClass_studentQuery::create()->filterByClassId($class_id)->count();
        $availableLicenses = TeacherHelper::getAvailableLicenses();
        if (empty($classLicences) === true) {
            $classLicences = 0;
        } else {
            $classLicences = $class->getLimit();
        }


        if ($classLicences > 2){
            $availableLicenses += $classLicences;
        }

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run('classes') === false) {
            if (form_error('name') != '')
                $error['name'] = form_error('name');
            if (form_error('class_code') != '')
                $error['class_code'] = form_error('class_code');
            $this->output->set_status_header('400');
        } else if ($licenses < 2 || ($licenses > $availableLicenses && $licenses > 2) || $studentsInClass > $licenses) {
            if ($licenses < 2) {
                $error['licenses'] = '2 licenses are free per class';
            } else if ($licenses > $availableLicenses) {
                $error['licenses'] = 'You have ' . $availableLicenses . ' licenses availalbe. <br/>You can <a href="/store" style="text-decoration: underline;">Purchase More</a> more at any time.';
            } else if ($studentsInClass > $licenses) {
                $error['licenses'] = 'Can\'t set class licenses to ' . $licenses . '<br/>You have ' . $studentsInClass . ' students assigned to class.';
            }
            $this->output->set_status_header('400');
        } else {
            /*
             * check for unique class code
             * */

            if(isset($class_id) === true && empty($class_id) === false){
                $check = $this->class_model->check_edit_class_code($code, $class_id);
            }else{
                $check = $this->class_model->check_class_code($code);
            }

            if($check === true){
                $error['class_code'] = 'Class code already exist';
                $this->output->set_status_header('400');
            }
        }

        if(empty($error) === true){
            $error['validation'] = true;
        }

        $this->output->set_output(json_encode($error));
    }

    /*
     * validation for add new student to class
     * */
    public function ajax_validation_new_student(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('class_student') === false){
            if(form_error('class_id') != '')
                $error['class_id'] = form_error('class_id');
            if(form_error('user_id') != '')
                $error['user_id'] = form_error('user_id');
            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));
    }

    /*
     * get students for specific class
     * @params: class_id
     * @output: array list of students and number of students it that class
     * */
    public function ajax_get_students(){

        $class_id = $this->input->post('class_id');
        $out = array();

        $out['students_count'] = 0;
        $out['students'] = array();

        $students = $this->class_model->get_students_from_class($class_id);

        foreach($students as $k=>$v){
            // get class-student record
            $classStudent = PropClass_studentQuery::create()
                ->filterByStudentId($v->getPropStudent()->getStudentId())
                ->filterByClassId($class_id)
                ->findOne();
            $out['students_count']++;
            $out['students'][$k]['user_id'] = $v->getUserId();
            $out['students'][$k]['first_name'] = $v->getFirstName();
            $out['students'][$k]['last_name'] = $v->getLastName();
            $out['students'][$k]['is_active'] = $classStudent->getIsActive();
        }

        $this->output->set_output(json_encode($out));
    }

    /*
     *  ajax function to get students to add to class
     *  @params class_id - id of class
     *  $output list of students
     * */
    public function ajax_get_excluded_students($class_id){
        $this->load->model('x_class_student/class_student_model');
        $student = $this->class_student_model->getStudentsExcludedFromClass($class_id);

        if(empty($student) === false){
            $out = array();
            foreach($student as $k=>$v){
                $out[$k]['user_id'] = $v->user_id;
                $out[$k]['first_name'] = $v->first_name;
                $out[$k]['last_name'] = $v->last_name;
            }
            $this->output->set_output(json_encode($out));
        }
    }

    public function ajax_set_student_active()
    {
        $user = PropUserQuery::create()->findOneByUserId($this->input->post('user_id'));
        $student = $user->getPropStudent();
        $classRoom = PropClasQuery::create()->findOneByClassId($this->input->post('class_id'));

        $classStudent = PropClass_studentQuery::create()
            ->filterByStudentId($student->getStudentId())
            ->filterByClassId($classRoom->getClassId())
            ->findOne();

        switch ($this->input->post('is_active')) {
            case 'no':
                $classStudent->setIsActive(PropClass_studentPeer::IS_ACTIVE_NO);
            break;
            case 'yes':
                $classStudent->setIsActive(PropClass_studentPeer::IS_ACTIVE_YES);
                break;
        }
        $classStudent->save();

        $output = array();
        $output['user_id'] = $user->getUserId();
        $output['first_name'] = $user->getFirstName();
        $output['last_name'] = $user->getLastName();
        $output['is_active'] = $classStudent->getIsActive();

        $this->output->set_output(json_encode($output));
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
     * ajax function to get all teacher classes
     * */

    public function ajax_get_class(){

        $this->class_model->filterByTeacherId(TeacherHelper::getId());
        $class_list = $this->class_model->getList();

        if(empty($class_list) === false){
            $out = array();
            foreach($class_list as$k=> $clas){
                $out[$k]['class_id'] = $clas->getId();
                $out[$k]['class_name'] = $clas->getClassName();
            }
        }
        $this->output->set_output(json_encode($out));
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
            $output->licenses = $class->getLimit();
            $output->name = $class->getName();
            $output->auth_code = $class->getAuthCode();
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
        $this->load->view(config_item('teacher_template'), $data);
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
    /*
     * function to generate class code
     * return random string
     * */
    public function ajax_class_code(){
        $code_status = true;
        while($code_status){
            $code = $this->classlib->generatePassword();
            $code_status = $this->class_model->check_class_code($code);
        }

        $this->output->set_output(json_encode($code));
    }

    public function ajax_delete_student_from_class(){
        $class_id = $this->input->post('class_id');
        $user_id = $this->input->post('user_id');

        $student_id = $this->users_model->get_student_id_by_user_id($user_id);
        $student = $this->class_student_model->delete($class_id,$student_id);


        $out = array('deleted'=>true);
        $this->output->set_output(json_encode($out));

    }

    public function ajax_reset_password(){
        $user_id= $this->input->post('user_id');
        $new_password   = $this->input->post('password');

        $this->users_model->change_password($user_id, $new_password);

        $student = $this->users_model->get_user_by_id($user_id);

        $data = new stdClass();
        $data->email = $student->getEmail();
        $data->first_name = $student->getFirstName();
        $data->last_name = $student->getLastName();

        if(ENVIRONMENT != 'development'){
            $this->send_mail_to_user(config_item('student_url'),$data,$new_password);
        }
    }

    private function send_mail_to_user($link_to_site,$data,$password){

        $subject = "[INFO CLASSCOMPETE]";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>Hi $data->first_name $data->last_name</p>
                    <p>Your password for classcompete teacher panel was changed</p>
                    <p>Link to site : $link_to_site</p>
                    <p>New password: <strong>$password</strong></p>";
        @mail($data->email, $subject, $email, $headers);
    }

}