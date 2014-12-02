<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 10/3/13
 * Time: 6:31 PM
 * To change this template use File | Settings | File Templates.
 */
class School extends MY_Controller{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('x_school/school_lib');
        $this->load->library('propellib');
        $this->propellib->load_object('School');
        $this->mapperlib->set_model($this->school_model);

        $this->load->library('form_validation');



        $c_value_set = PropSchoolPeer::getValueSets();

        $this->mapperlib->add_column('name', 'Name', true);
        $this->mapperlib->add_column('state', 'State', true);
        $this->mapperlib->add_column('country', 'Country', true);
        $this->mapperlib->add_column('city', 'City', true);
        $this->mapperlib->add_column('county', 'County', true);
        $this->mapperlib->add_column('zip_code', 'Zip code', true);
        $this->mapperlib->add_column('approved', 'Approved', true,'select', $c_value_set[PropSchoolPeer::APPROVED]);
        $this->mapperlib->add_column('is_public', 'Public', true,'select', $c_value_set[PropSchoolPeer::IS_PUBLIC]);


        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name',
            ),
            'uri' => '#school/edit',
            'params' => array(
                'id',
            ),
            'data-toggle' => 'modal',
            'data-target' => '#addEditSchool'
        ));
        $this->mapperlib->add_option('decline', array(
            'title' => array(
                'base' => 'Decline',
                'field' => 'name',
            ),
            'uri' => 'school/decline_school_redirect',
            'params' => array(
                'id',
            ),
            'data-toggle' => 'modal',
            'data-target' => '#declineSchool'
        ));
        if($this->uri->segment('2') == 'pending'){
            $this->mapperlib->add_option('approve',array(
                'title'=>array(
                    'base' => 'Approve',
                    'field' => 'name'
                ),
                'uri'=>'school/approve_school',
                'params'=>array(
                    'id'
                ),
                'data-toggle' => 'modal',
                'data-target' => '#approveSchool'
            ));
        }


        $this->mapperlib->add_order_by('name', 'Name');
        $this->mapperlib->add_order_by('state', 'State');
        $this->mapperlib->add_order_by('city', 'City');
        $this->mapperlib->add_order_by('county', 'County');
        $this->mapperlib->add_order_by('country', 'Country');
        $this->mapperlib->add_order_by('zip_code', 'Zip code');
        $this->mapperlib->add_order_by('approved', 'Approved');
        $this->mapperlib->add_order_by('public', 'Public');

        $this->mapperlib->set_default_per_page(250);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('school/index');

        $this->mapperlib->set_default_order(PropSchoolPeer::NAME, Criteria::ASC);

    }
    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('school/index/' . $uri);
        }

        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);
        $data->count_schools = $this->school_model->getFoundRows();

        $data->content = $this->prepareView('x_school', 'home_admin', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

        public function pending(){
            $uri = Mapper_Helper::create_uri_segments();
            if ($uri !== null) {
                redirect('school/pending/' . $uri);
            }

            $data = new stdClass();

            $this->school_model->filterByApproved(PropSchoolPeer::APPROVED_NOT_APPROVED);
            $data->table = $this->mapperlib->generate_table(true);
            $data->count_schools = $this->school_model->getFoundRows();

            $data->content = $this->prepareView('x_school', 'home_admin', $data);
            $this->load->view(config_item('admin_template'), $data);
        }

    public function ajax(){
        $school_id = $this->input->post('school_id');
        $school = $this->school_model->get_school($school_id);

        if (empty($school) === false) {
            $output = new stdClass();
            $output->id = $school->getSchoolId();
            $output->name = $school->getName();
            $output->state = $school->getState();
            $output->country = $school->getCountry();
            $output->city = $school->getCity();
            $output->county = $school->getCounty();
            $output->zip_code = $school->getZipCode();
            $output->approved = $school->getApproved();
            $output->public = $school->getIsPublic();

            $this->output->set_output(json_encode($output));
        }
    }

        public function decline_school(){
            $school_id = $this->input->post('school_id');

            $out = array();


            $school = $this->school_model->decline_school($school_id);

            $out['deleted'] = true;


            $this->output->set_output(json_encode($out));
        }

    public function decline_school_redirect($school_id){
        $school_exist = PropSchoolQuery::create()->findOneBySchoolId($school_id);

        if (isset($school_exist) === true && empty($school_exist) === false){
            $school = $this->school_model->decline_school($school_id);
        }

        redirect('school');
    }

    public function approve_school($school_id){
        $this->school_model->approve_school($school_id);
        redirect('school');
    }

        public function save_school(){
            if($this->form_validation->run('school') === false){
                redirect();
            }

            $data = new stdClass();

            $school_id = $this->input->post('school_id');
            $data->name = $this->input->post('name');
            $data->state = $this->input->post('state');
            $data->country = $this->input->post('country');
            $data->city = $this->input->post('city');
            $data->county = $this->input->post('county');
            $data->zip_code = $this->input->post('zip_code');
            $data->approved = $this->input->post('approved');
            $data->public = $this->input->post('public');


            $this->school_model->save($data, $school_id);


            $out = array();

            $out['saved'] = true;

            $this->output->set_output(json_encode($out));

        }

        public function ajax_school_validation(){

            $error = array();
            $this->form_validation->set_error_delimiters('', '');

            if($this->form_validation->run('school') === false){
                if(form_error('name')!= '')
                    $error['name'] = form_error('name');
                if(form_error('state')!= '')
                    $error['state'] = form_error('state');
                if(form_error('country')!= '')
                    $error['country'] = form_error('country');
                if(form_error('city')!= '')
                    $error['city'] = form_error('city');
                if(form_error('county')!= '')
                    $error['county'] = form_error('county');
                if(form_error('zip_code')!= '')
                    $error['zip_code'] = form_error('zip_code');
                if(form_error('approved')!= '')
                    $error['approved'] = form_error('approved');
                if(form_error('public')!= '')
                    $error['public'] = form_error('public');
            $this->output->set_status_header(400);
        }else{
            $error['validation'] = true;
        }

        $this->output->set_output(json_encode($error));
    }

    public function ajax_get_schools_by_name(){
        $school = $this->input->post('school');

        $query = $this->school_model->find_school($school['school'], $school['zip_code']);


        $this->output->set_output(json_encode($query));

    }
}