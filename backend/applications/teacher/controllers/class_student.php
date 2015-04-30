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
        $this->load->library('propellib');
        $this->load->library('form_validation');

        $this->propellib->load_object('Class_student');
        $this->mapperlib->set_model($this->class_student_model);


        $this->mapperlib->add_column('class_name', 'Class Name', true, 'text','PropClas');
        $this->mapperlib->add_column('student_first_name', 'Student first name', false, 'text','PropStudent');
        $this->mapperlib->add_column('student_last_name', 'Student last name', false, 'text','PropStudent');

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Status',
                'field' => 'name',
            ),
            'uri' => '#',
            'params' => array(
                'id',
            ),
            'data-target' => '#',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_order_by('class_name', 'Class name');
        $this->mapperlib->add_order_by('student_first_name', 'Student first name');
        $this->mapperlib->add_order_by('student_last_name', 'Student last name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('class_student/index');

        $this->mapperlib->set_default_order(PropClass_studentPeer::CLASS_ID, Criteria::ASC);
    }

	//Pedja 30.04.2015: I don't know where these methods are used in Teacher panel.
	//It seems that this is only the stub of functionality, code is just started but not finished.
    public function index(){
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('class_student/index/' . $uri);
        }

        $data = new stdClass();

        $this->class_student_model->setTeacherId(TeacherHelper::getId());
        $data->table = $this->mapperlib->generate_table(true);

        $data->content = $this->prepareView('x_class_student', 'home', $data);
        $this->load->view(config_item('teacher_template'), $data);
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

        $data = new stdClass();

        if (empty($student_id) === false) {
            $this->class_student_model->filterByStudentId($student_id);
        }

        $data->table = $this->mapperlib->generate_table(true);

        $data->content = $this->prepareView('x_class_student', 'home', $data);
        $this->load->view(config_item('teacher_template'), $data);
    }

    public function save(){
        $this->load->library('form_validation');

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

        $this->class_student_model->setTeacherId(TeacherHelper::getId());
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
        $student = $this->class_student_model->getExcludedStudent($class_id);

        if(empty($student) === false){
            $out = array();
            foreach($student as $k=>$v){
                $out[$k]['user_id'] = $v->getUserId();
                $out[$k]['first_name'] = $v->getFirstName();
                $out[$k]['last_name'] = $v->getLastName();
            }
            $this->output->set_output(json_encode($out));
        }
    }

    public function ajax_get_students(){
        $class_id = $this->input->post('class_id');
        $students = $this->class_student_model->getStudentsExcludedFromClass($class_id);
        $this->output->set_output(json_encode($students));
    }
}