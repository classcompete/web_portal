<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/19/13
 * Time: 3:17 PM
 * To change this template use File | Settings | File Templates.
 */
class Connection extends MY_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->library('x_connection/connectionlib');
        $this->load->library('propellib');
        $this->propellib->load_object('Connection');
        $this->mapperlib->set_model($this->connection_model);

        $this->mapperlib->add_column('from_user_login', 'From - user login', true, 'text', 'PropUser');
        $this->mapperlib->add_column('to_user_login', 'To - user login', true, 'text', 'PropUser');
        $this->mapperlib->add_column('created', 'Created', false);
        $this->mapperlib->add_column('modified', 'Modified', false);
        $this->mapperlib->add_column('status', 'Status', true);


        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'from_user_login',
            ),
            'uri' => '#connection/edit',
            'params' => array(
                'id',
            ),
            'data-toggle' => 'modal',
            'data-target' => '#addEditConnection'
        ));

        $this->mapperlib->add_order_by('from_user_login', 'From - user login');
        $this->mapperlib->add_order_by('to_user_login', 'To - user login');
        $this->mapperlib->add_order_by('status', 'status');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('connection/index');

        $this->mapperlib->set_default_order(PropConnectionPeer::CONN_ID, Criteria::ASC);

    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('connection/index/' . $uri);
        }

        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);

        $data->content = $this->prepareView('x_connection', 'home', $data);
        $this->load->view(config_item('teacher_template'), $data);
    }

    public function save()
    {

        /*
         * validation part
         * */

        $this->load->library('form_validation');

        $this->form_validation->set_rules('from_user', 'From user ', 'required|trim');
        $this->form_validation->set_rules('to_user', 'To user ', 'required|trim');
        $this->form_validation->set_rules('status', 'Status ', 'required|trim');

        $id = $this->input->post('connection_id');

        if ($this->form_validation->run() === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        /*
         * prepare data for save
         * */

        $data = new stdClass();
        $data->from_user_id = $this->input->post('from_user');
        $data->to_user_id = $this->input->post('to_user');
        $data->status = $this->input->post('status');

        //var_dump($data);

        $this->connection_model->save($data, $id);
        redirect('connection');
    }

    /*
     * get predefined status
     * */

    public function ajax_get_status()
    {
        $status = array(
            'accepted',
            'ignored',
            'init',
            'invited',
            'rejected',
            'revoked'
        );

        $this->output->set_output(json_encode($status));
    }

    /*
     * get all users
     * */
    public function ajax_get_all_users()
    {
        $users = $this->connection_model->get_all_users();

        if (empty($users) === false) {
            $out = array();
            foreach ($users as $k => $v) {
                $out[$k]['user_id'] = $v->getUserId();
                $out[$k]['first_name'] = $v->getFirstName();
                $out[$k]['last_name'] = $v->getLastName();
            }
        }

        $this->output->set_output(json_encode($out));
    }

    /*
     * get users excluded by user_id
     * */
    public function ajax_get_excluded_users($id)
    {
        $users = $this->connection_model->get_user_exclude_by_id($id);
        if (empty($users) === false) {
            $out = array();
            foreach ($users as $k => $v) {
                $out[$k]['user_id'] = $v->getUserId();
                $out[$k]['first_name'] = $v->getFirstName();
                $out[$k]['last_name'] = $v->getLastName();
            }
        }

        $this->output->set_output(json_encode($out));
    }

    public function ajax($id)
    {
        $connection = $this->connection_model->get_connection_by_id($id);

        if (empty($connection) === false) {
            $output = new stdClass();
            $output->id = $connection->getId();
            $output->from_user_id = $connection->getFromUserId();
            $output->to_user_id = $connection->getToUserId();
            $output->status = $connection->getStatus();

            $this->output->set_output(json_encode($output));
        }
    }
}