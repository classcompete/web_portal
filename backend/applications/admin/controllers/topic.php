<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/22/13
 * Time: 10:42 AM
 * To change this template use File | Settings | File Templates.
 */
class Topic extends MY_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('x_topic/topiclib');
        $this->load->library('propellib');
        $this->load->library('form_validation');

        $this->propellib->load_object('Topic');
        $this->mapperlib->set_model($this->topic_model);

        $this->mapperlib->add_column('name', 'Topic name', true);
        $this->mapperlib->add_column('skill_name', 'Skill name', true);
        $this->mapperlib->add_column('subject_name', "Subject name", false, 'text', 'PropSubjects');

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name'
            ),
            'uri' => '#topic/edit',
            'params' => array(
                'topic_id'
            ),
            'data-target' => '#addEditTopic',
            'data-toggle' => 'modal',
        ));

        $this->mapperlib->add_order_by('name', 'Topic name');
        $this->mapperlib->add_order_by('skill_name', 'Skill name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('topic/index');

        $this->mapperlib->set_default_order(PropTopicPeer::TOPIC_ID, Criteria::ASC);

    }

    public function index(){

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('topic/index/' . $uri);
        }
        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);

        $data->count_subtopics = $this->topic_model->getFoundRows();

        $data->content = $this->prepareView('x_topic', 'home', $data);

        $this->load->view(config_item('admin_template'), $data);

    }

    public function save(){

        $id = intval($this->input->post('edit_topic_id'));

        if ($this->form_validation->run('topic') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }else {
            $topic_name = $this->input->post('name');
            $unique_topic = $this->topic_model->is_unique_topic($topic_name);

            if( isset($unique_topic) === true && empty($unique_topic) === false){
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        /*
         * prepare data for save
         * */

        $data = new stdClass();
        $data->name = $this->input->post('name');
        $data->skill_id = $this->input->post('skill_id');


        $this->topic_model->save($data, $id);

        redirect('topic');

    }

    /*
     * validation function for save function
     * */

    public function ajax_validation(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('topic') === false){
            if(form_error('name') != '')
                $error['name'] = form_error('name');
            if(form_error('skill_id') != '')
                $error['skill_id'] = form_error('skill_id');

            $this->output->set_status_header('400');
        }else {
            $topic_name = $this->input->post('name');
            $unique_topic = $this->topic_model->is_unique_topic($topic_name);
            if( isset($unique_topic) === true && empty($unique_topic) === false){
                $error['name'] = 'Subtopic name is already used';
                $this->output->set_status_header('400');
            }else{
                $error['validation'] = true;
                $this->output->set_status_header('200');
            }
        }

        $this->output->set_output(json_encode($error));

    }

    /*
     * Get list of skills
     * */

    public function ajax_get_skills(){

        $this->load->model('x_subject/skill_model');

        $skills = $this->skill_model->getList();

        if(empty($skills) === false){
            $out = array();
            foreach($skills as $k=>$v){
                $out[$k]['skill_id'] = $v->getSkillId();
                $out[$k]['name'] = $v->getName();
            }

            $this->output->set_output(json_encode($out));
        }

    }

    public function ajax($id)
    {
        $topic = $this->topic_model->get_topic_by_id($id);

        if (empty($topic) === false) {
            $output = new stdClass();
            $output->topic_id = $topic->getTopicId();
            $output->skill_id = $topic->getSkillId();
            $output->name = $topic->getName();

            $this->output->set_output(json_encode($output));
        }
    }

}