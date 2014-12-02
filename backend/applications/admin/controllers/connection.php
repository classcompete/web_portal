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
        $this->load->library('x_parent_student_connection/parentstudentconnectionlib');
        $this->load->library('propellib');
        $this->propellib->load_object('ParentStudents');
        $this->mapperlib->set_model($this->parent_student_connection_model);

        $this->load->library('form_validation');

        $this->mapperlib->add_column('parent_username', 'Parent login', true);
        $this->mapperlib->add_column('student_username', 'Student login', true);
        $this->mapperlib->add_column('created_at', 'Created', false);
        $this->mapperlib->add_column('updated_at', 'Modified', false);
//        $this->mapperlib->add_column('status', 'Status', true);


//        $this->mapperlib->add_option('edit', array(
//            'title' => array(
//                'base' => 'Edit',
//                'field' => 'parent_username',
//            ),
//            'uri' => '#connection/edit',
//            'params' => array(
//                'id',
//            ),
//            'data-toggle' => 'modal',
//            'data-target' => '#addEditConnection'
//        ));

        $this->mapperlib->add_option('delete', array(
            'title' => array(
                'base' => 'Delete',
                'field' => 'parent_username',
            ),
            'uri' => 'connection/delete',
            'params' => array(
                'id',
            ),
            'data-toggle' => 'modal',
            'data-target' => '#deleteConnection'
        ));

        $this->mapperlib->add_order_by('parent_username', 'Parent login');
        $this->mapperlib->add_order_by('student_username', 'Student login');
//        $this->mapperlib->add_order_by('status', 'status');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_breaking_segment(3);
        $this->mapperlib->set_default_base_page('connection/index');

        $this->mapperlib->set_default_order(PropParentStudentsPeer::CREATED_AT, Criteria::DESC);

    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('connection/index/' . $uri);
        }

        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);
        $data->count_connections = $this->parent_student_connection_model->getFoundRows();

        //$data->content = $this->prepareView('x_connection', 'home', $data);
        $data->content = $this->prepareView('x_parent_student_connection', 'home', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function save()
    {

        $id = $this->input->post('connection_id');

        if ($this->form_validation->run('connection') === false) {
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
    * validation function for save function
    * */

    public function ajax_validation()
    {

        $error = array();

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run('connection') === false) {
            if (form_error('from_user') != '')
                $error['from_user'] = form_error('from_user');
            if (form_error('to_user') != '')
                $error['to_user'] = form_error('to_user');
            if (form_error('status') != '')
                $error['status'] = form_error('status');

            $this->output->set_status_header('400');
        } else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));

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

    public function delete($id)
    {

//        $error = array();

        $delete = $this->parent_student_connection_model->delete_by_id($id);

//        $out = new stdClass();
//
//        if ($delete === null) {
//            $out->deleted = false;
//        } else {
//            $out->deleted = $delete;
//        }

//        $this->output->set_output(json_encode($out));
        redirect('connection');
    }
}