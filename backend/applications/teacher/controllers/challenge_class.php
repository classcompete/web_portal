<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/15/13
 * Time: 10:43 AM
 * To change this template use File | Settings | File Templates.
 */
class Challenge_class extends MY_Controller{
    public function __construct(){
        parent:: __construct();
        $this->load->library('x_challenge_class/challenge_classlib');
        $this->load->library('propellib');
        $this->load->library('form_validation');

        $this->propellib->load_object('ChallengeClass');
        $this->mapperlib->set_model($this->challenge_class_model);

        $this->mapperlib->add_column('name_challenge', 'Challenge name', true);
        $this->mapperlib->add_column('name_class', 'Class name', true, 'text','PropClass');

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name_challenge',
            ),
            'uri' => '#challange_class/edit',
            'params' => array(
                'id',
            ),
            'data-target' => '#addEditChallengeClass',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_order_by('name_challenge', 'Challenge name');
        $this->mapperlib->add_order_by('name_class', 'Class name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('challenge_class/index');

        $this->mapperlib->set_default_order(PropChallengeClassPeer::CHALLCLASS_ID, Criteria::ASC);

    }
    public function index(){
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('challenge_class/index/' . $uri);
        }

        $data = new stdClass();

        $this->challenge_class_model->setTeacherId(TeacherHelper::getId());
        $data->table = $this->mapperlib->generate_table(true);

        $data->content = $this->prepareView('x_challenge_class', 'home', $data);
        $this->load->view(config_item('teacher_template'), $data);

    }

    public function save(){

        $challclass_id = $this->input->post('id');

        if ($this->form_validation->run('challenge_class') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $challclass_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }


        $new_challenge_class = new stdClass();
        $new_challenge_class->challenge_id = intval($this->input->post('challenge_id'));
        $new_challenge_class->class_id = intval($this->input->post('class_id'));

        $r = $this->challenge_class_model->save($new_challenge_class, $challclass_id);

        redirect('challenge_class');
    }

    public function ajax_validation(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('challenge_class') === false){
            if(form_error('challenge_id') != '')
                $error['challenge_id'] = form_error('challenge_id');
            if(form_error('class_id') != '')
                $error['class_id'] = form_error('class_id');

            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));

    }

    public function ajax_get_challenges(){
        $challenge = $this->challenge_class_model->get_challenges();

        if(empty($challenge) === false){
            $ch = array();
            foreach($challenge as $k=>$val){
                $ch[$k]['challenge_id'] = $val->getChallengeId();
                $ch[$k]['name'] = $val->getName();
            }

        }
        $this->output->set_output(json_encode($ch));
    }

    public function ajax_get_challenges_class(){

        $this->challenge_class_model->setTeacherId(TeacherHelper::getId());
        $class = $this->challenge_class_model->get_classes();

        if(empty($class) === false){
            $ch = array();
            foreach($class as $k=>$val){
                $ch[$k]['class_id'] = $val->getClassId();
                $ch[$k]['name'] = $val->getName();
            }

        }

        $this->output->set_output(json_encode($ch));
    }
    public function ajax_get_challenge($id){
        $challenge_class = $this->challenge_class_model->get_challenge_class_by_id($id);

        if(empty($challenge_class) === false){
            $out = array();
            $out['challenge_id'] = $challenge_class->getChallengeId();
            $out['class_id'] = $challenge_class->getClassId();
            $out['challclass_id'] = $challenge_class->getChallclassId();
        }

        $this->output->set_output(json_encode($out));
    }
}