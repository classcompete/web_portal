<?php

class Teacher extends MY_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('x_teacher/teacherlib');
        $this->load->library('propellib');

        $this->propellib->load_object('Teacher');
        $this->mapperlib->set_model($this->teacher_model);

        $this->mapperlib->add_column('name', 'Name', true);

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name'
            ),
            'uri' => '#teacher/edit',
            'params' => array(
                'teacher_id'
            ),
            'data-target' => '#addEditTeacher',
            'data-toggle' => 'modal',
        ));

        $this->mapperlib->add_order_by('name', 'Name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('teacher/index');

        $this->mapperlib->set_default_order(PropTeacherPeer::TEACHER_ID, Criteria::ASC);
    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('teacher/index/' . $uri);
        }
        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);

        $data->content = $this->prepareView('x_teacher', 'home', $data);

        $this->load->view(config_item('admin_template'), $data);
    }

    public function add_new()
    {
        $this->teacher_form(null, true);
    }

    public function edit($id)
    {
        $teacher = $this->teacher_model->get_teacher_by_id($id);
        $this->teacher_form($teacher);
    }

    public function ajax($id)
    {
        $teacher = $this->teacher_model->get_teacher_by_id($id);

        if (empty($teacher) === false){
            $output = new stdClass();
            $output->id = $teacher->getTeacherId();
            $output->name = $teacher->getName();

            $this->output->set_output(json_encode($output));
        }
    }

    public function teacher_form(PropTeacher $teacher = null, $add_new = false)
    {

        $data = new stdClass();

        if (is_object($teacher)) {
            $_POST = array(
                'name' => $teacher->getName()
            );
            $flashdata = $this->session->flashdata('admin-' . $teacher->getTeacherId());
            if (empty($flashdata) === false) {
                $_POST = array_merge($_POST, $flashdata);
            }
        } else {
            $_POST = $this->session->flashdata('admin-');
        }

        $data->teacher = $teacher;
        $data->add_new = $add_new;
        $data->content = $this->prepareView('x_teacher', 'form', $data);
        $this->load->view('form', $data);
    }

    public function save()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'required|xss_clean|trim');

        $teacher_id = $this->input->post('id');
        if ($this->form_validation->run() === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $teacher_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $teacher_data = new stdClass();

        $teacher_data->name = $this->input->post('name');

        $teacher = $this->teacher_model->save($teacher_data, $teacher_id);
        redirect('teacher');
    }
}