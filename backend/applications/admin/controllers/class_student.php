<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/11/13
 * Time: 7:05 PM
 * To change this template use File | Settings | File Templates.
 */
class Class_Student extends MY_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->library('x_class_student/class_studentlib');
        $this->load->library('x_users/userslib');
        $this->load->library('propellib');

        $this->load->library('form_validation');

        $this->propellib->load_object('Class_student');
        $this->mapperlib->set_model($this->class_student_model);


        $this->mapperlib->add_column('name', 'Class Name', true, 'text',null,'PropClas');
        $this->mapperlib->add_column('student_first_name', 'Student first name', false, 'text',null,'PropStudent');
        $this->mapperlib->add_column('student_last_name', 'Student last name', false, 'text',null,'PropStudent');

        $this->mapperlib->add_order_by('name', 'Class name','PropClas');
        $this->mapperlib->add_order_by('first_name', 'Student first name','PropUser');
        $this->mapperlib->add_order_by('last_name', 'Student last name','PropUser');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('class_student/index');
        $this->mapperlib->set_default_order(PropClass_studentPeer::CLASS_ID, Criteria::ASC);
    }
    public function add_new(){
        $student = $this->class_student_model->getStudents();
        $class = $this->class_student_model->getClass();
        $this->cs_form($student, $class, true);
    }
    public function index($class_id = null){
        if (intval($class_id) > 0) {
            $this->mapperlib->set_breaking_segment(4);
            $this->mapperlib->set_default_base_page('class_student/index/' . $class_id);
            $teacherUri = $class_id . '/';
        } else {
            $this->mapperlib->set_breaking_segment(1);
            $this->mapperlib->set_default_base_page('class_student/index');
            $teacherUri = null;

        }$uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('class_student/index/' . $teacherUri . $uri);
        }

        $data = new stdClass();
        if(empty($class_id) === false && intval($class_id) > 0){
            $this->class_student_model->setClassId($class_id);
        }
        $data->table = $this->mapperlib->generate_table(true);
        $data->count_class_student = $this->class_student_model->getFoundRows();
        $data->content = $this->prepareView('x_class_student', 'home', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function students($student_id = null)
    {
        if (intval($student_id) > 0) {
            $this->mapperlib->set_breaking_segment(4);
            $this->mapperlib->set_default_base_page('class_student/students/' . $student_id);
            $studentUri = $student_id . '/';
        } else {
            $this->mapperlib->set_breaking_segment(3);
            $this->mapperlib->set_default_base_page('class_student/students');
            $studentUri = null;
        }

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {

            redirect('class_student/index/' . $studentUri . $uri);
        }


        $this->mapperlib->add_option('admin_student_profile', array(
            'title' => array(
                'base' => 'View student results',
                'field' => null,
            ),
            'uri' => '#/student_info',
            'params' => array(
                'user_id',
                'class_id'
            ),
            'data-target' => '#studentInfo',
            'data-toggle' => 'modal'
        ));

        $data = new stdClass();

        if (empty($student_id) === false) {
            $id = $this->users_model->get_student_id_by_user_id($student_id);
            $this->class_student_model->filterByStudentId($id);
        }

        $data->table = $this->mapperlib->generate_table(true);
        $data->count_class_student = $this->class_student_model->getFoundRows();

        $data->content = $this->prepareView('x_class_student', 'home', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function save(){

        $class_student_id = $this->input->post('class_student_id');

        if ($this->form_validation->run('class_student') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $class_student_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $classStudentData = new stdClass();
        $classStudentData->class_id = $this->input->post('class_id');
        $classStudentData->user_id = $this->input->post('user_id');

        $this->class_student_model->save($classStudentData, $class_student_id);

        redirect('class_student');
    }

    /*
    * validation function for save function
    * */

    public function ajax_validation(){

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

    public function ajax_get_class(){
        $class = $this->class_student_model->getClass();

        if(empty($class) === false){
            $out = array();
            foreach($class as$k=> $clas){
                $out[$k]['class_id'] = $clas->getId();
                $out[$k]['class_name'] = $clas->getClassName();
            }
        }
        $this->output->set_output(json_encode($out));
    }

    public function ajax_get_excluded_students($class_id){
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

    public function ajax_get_students($class_id){
        $students = $this->class_student_model->getStudentsExcludedFromClass($class_id);
        $this->output->set_output(json_encode($students));
    }

    public function ajax($id)
    {
        $class_student = $this->class_student_model->get_class_student_by_id($id);

        if (empty($class_student) === false) {
            $this->load->model('x_users/users_model');
            $student = $this->users_model->get_student_by_student_id($class_student->getStudentId());

            $output = new stdClass();
            $output->id = $class_student->getClassstudId();
            $output->class_id = $class_student->getClassId();
            $output->student_id = $class_student->getStudentId();
            $output->user_id = $student->getUserId();

            $this->output->set_output(json_encode($output));
        }
    }

}