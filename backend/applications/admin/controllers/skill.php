<?php

class Skill extends MY_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('x_subject/skilllib');
        $this->load->library('propellib');
        $this->load->library('form_validation');

        $this->propellib->load_object('Skills');
        $this->mapperlib->set_model($this->skill_model);

        $this->mapperlib->add_column('name', 'Name', true);
        $this->mapperlib->add_column('subject_name', "Subject name");

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name'
            ),
            'uri' => '#skill/edit',
            'params' => array(
                'skill_id'
            ),
            'data-target' => '#addEditSkill',
            'data-toggle' => 'modal'
        ));
        $this->mapperlib->add_option('delete', array(
            'title' => array(
                'base' => 'Delete',
                'field' => 'name'
            ),
            'uri' => 'skill/delete',
            'params' => array(
                'skill_id'
            ),
            'data-target' => '',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_order_by('name', 'Name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_breaking_segment(3);
        $this->mapperlib->set_default_base_page('skill/index');

        $this->mapperlib->set_default_order(PropSkillsPeer::NAME, Criteria::ASC);
    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('skill/index/' . $uri);
        }
        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);

        $data->count_topics = $this->skill_model->getFoundRows();

        $data->content = $this->prepareView('x_subject', 'home_skill', $data);

        $this->load->view(config_item('admin_template'), $data);
    }

    public function add_new()
    {
        $this->skill_form(null, true);
    }

    public function edit($id)
    {
        $skill = $this->skill_model->get_skill_by_id($id);
        $this->skill_form($skill);
    }

    public function ajax($id)
    {
        $skill = $this->skill_model->get_skill_by_id($id);
        if (empty($skill) === false) {
            $output = new stdClass();
            $output->id = $skill->getSkillId();
            $output->subject_id = $skill->getSubjectId();
            $output->name = $skill->getName();

            $this->output->set_output(json_encode($output));
        }
    }

    public function ajax_subjects()
    {
        $this->load->model('x_subject/subject_model');

        $subjects = $this->subject_model->getList();
        $subjects_array = array();
        foreach ($subjects as $k => $subject) {
            $subjects_array[$k]['subject_id'] = $subject->getSubjectId();
            $subjects_array[$k]['name'] = $subject->getName();
        }

        $this->output->set_output(json_encode($subjects_array));
    }
    public function ajax_get_skill_by_subject_id($id){
        $skills = $this->skill_model->get_skill_by_subject_id($id);

        if(empty($skills) === false){
            $out = array();
            foreach($skills as $k=>$v){
                $out[$k]['skill_id'] = $v->getSkillId();
                $out[$k]['skill_name'] = $v->getName();
            }
            $this->output->set_output(json_encode($out));
        }

    }

    public function skill_form(PropSkills $skill = null, $add_new = false)
    {

        $data = new stdClass();

        if (is_object($skill)) {
            $_POST = array(
                'name' => $skill->getName()
            );
            $flashdata = $this->session->flashdata('admin-' . $skill->getSkillId());
            if (empty($flashdata) === false) {
                $_POST = array_merge($_POST, $flashdata);
            }
        } else {
            $_POST = $this->session->flashdata('admin-');
        }

        $data->skill = $skill;
        $data->add_new = $add_new;
        $data->content = $this->prepareView('x_subject', 'form_skill', $data);
        $this->load->view('form_skill', $data);
    }

    public function save(){

        $skill_id = $this->input->post('id');
        if ($this->form_validation->run('skill') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $skill_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }


        $skill_data = new stdClass();

        $skill_data->name = $this->input->post('name');
        $skill_data->subject_id = $this->input->post('subject_id');

        $skill = $this->skill_model->save($skill_data, $skill_id);
        redirect('skill');
    }

    /*
    * validation function for save function
    * */

    public function ajax_validation(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('skill') === false){
            if(form_error('name') != '')
                $error['name'] = form_error('name');

            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));

    }

    public function delete($skill_id){
        $error = array();
        try{
            $this->skill_model->delete($skill_id);
            $error['passed'] = true;
        }catch (Exception $e){
            $error['error'] = $e->getMessage();
            $this->output->set_status_header(400);
        }

        $this->output->set_output(json_encode($error));
    }
}