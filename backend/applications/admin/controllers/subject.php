<?php

class Subject extends MY_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('x_subject/subjectlib');
        $this->load->library('propellib');
        $this->load->library('form_validation');

        $this->propellib->load_object('Subjects');
        $this->mapperlib->set_model($this->subject_model);

        $this->mapperlib->add_column('name', 'Name', true);

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name'
            ),
            'uri' => '#subject/edit',
            'params' => array(
                'subject_id'
            ),
            'data-target' => '#addEditSubject',
            'data-toggle' => 'modal',
        ));

        $this->mapperlib->add_order_by('name', 'Name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('subject/index');

        $this->mapperlib->set_default_order(PropSubjectsPeer::NAME, Criteria::ASC);
    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('subject/index/' . $uri);
        }
        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);

        $data->count_subject = $this->subject_model->getFoundRows();

        $data->content = $this->prepareView('x_subject', 'home', $data);

        $this->load->view(config_item('admin_template'), $data);
    }

    public function add_new()
    {
        $this->subject_form(null, true);
    }

    public function edit($id)
    {
        $subject = $this->subject_model->get_subject_by_id($id);
        $this->subject_form($subject);
    }

    public function ajax($id)
    {
        $subject = $this->subject_model->get_subject_by_id($id);

        if (empty($subject) === false){
            $output = new stdClass();
            $output->id = $subject->getSubjectId();
            $output->name = $subject->getName();

            $this->output->set_output(json_encode($output));
        }
    }
    public function get_subjects(){
        $subject = $this->subject_model->getList();
        if (empty($subject) === false){
            $output = array();
            foreach($subject as $k=>$val){
                $output[$k]['subject_id'] = $val->getSubjectId();
                $output[$k]['name'] = $val->getName();

            }
            $this->output->set_output(json_encode($output));
        }
    }

    public function subject_form(PropSubjects $subject = null, $add_new = false)
    {

        $data = new stdClass();

        if (is_object($subject)) {
            $_POST = array(
                'name' => $subject->getName()
            );
            $flashdata = $this->session->flashdata('admin-' . $subject->getSubjectId());
            if (empty($flashdata) === false) {
                $_POST = array_merge($_POST, $flashdata);
            }
        } else {
            $_POST = $this->session->flashdata('admin-');
        }

        $data->subject = $subject;
        $data->add_new = $add_new;
        $data->content = $this->prepareView('x_subject', 'form', $data);
        $this->load->view('form', $data);
    }

    public function save(){

        $subject_id = $this->input->post('id');
        if ($this->form_validation->run('subject') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $subject_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $subject_data = new stdClass();

        $subject_data->name = $this->input->post('name');

        $subject = $this->subject_model->save($subject_data, $subject_id);
        redirect('subject');
    }

    /*
   * validation function for save function
   * */

    public function ajax_validation(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('subject') === false){
            if(form_error('name') != '')
                $error['name'] = form_error('name');

            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));

    }
}