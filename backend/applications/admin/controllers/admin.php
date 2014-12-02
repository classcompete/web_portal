<?php

class Admin extends MY_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->library('x_admin/adminlib');
        $this->load->library('propellib');

        $this->load->library('form_validation');

        $this->propellib->load_object('Admin');
        $this->mapperlib->set_model($this->admin_model);

        $this->mapperlib->add_column('username', 'USERNAME', true);
        $this->mapperlib->add_column('first_name', 'FIRST NAME', true);
        $this->mapperlib->add_column('last_name', 'LAST NAME', true);
        $this->mapperlib->add_column('email', 'EMAIL', true);
        $this->mapperlib->add_column('last_login_time', 'LAST LOGIN TIME', false);
        $this->mapperlib->add_column('created_at', 'CREATED AT', false);
        $this->mapperlib->add_column('updated_at', 'UPDATED AT', false);

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'username',
            ),
            'uri' => '#admin/edit',
            'params' => array(
                'id',
            ),
            'data-target' => '#addEditAdmin',
            'data-toggle' => 'modal'
        ));
        $this->mapperlib->add_option('delete', array(
            'title' => array(
                'base' => 'Delete',
                'field' => 'username'
            ),
            'uri' => 'admin/delete',
            'params' => array(
                'id'
            )
        ));

        $this->mapperlib->add_order_by('username', 'USERNAME');
        $this->mapperlib->add_order_by('first_name', 'FIRST NAME');
        $this->mapperlib->add_order_by('last_name', 'LAST NAME');


        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('admin/index');

        $this->mapperlib->set_default_order(PropAdminPeer::CREATED_AT, Criteria::DESC);
    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('admin/index/' . $uri);
        }

        $data = new stdClass();

        $this->admin_model->excludeById(AdminHelper::get_admin_id());
        $data->table = $this->mapperlib->generate_table(true);

        $data->content = $this->prepareView('x_admin', 'home', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function add_new()
    {
        $this->admin_form(null, true);
    }

    public function edit($id)
    {
        $admin = $this->admin_model->get_admin_by_id($id);

        $this->admin_form($admin);
    }

    public function ajax($id)
    {
        $admin = $this->admin_model->get_admin_by_id($id);

        if (empty($admin) === false) {
            $output = new stdClass();
            $output->id = $admin->getId();
            $output->username = $admin->getUsername();
            $output->first_name = $admin->getFirstName();
            $output->last_name = $admin->getLastName();
            $output->email = $admin->getEmail();

            $this->output->set_output(json_encode($output));
        }
    }

    private function admin_form(PropAdmin $admin = null, $add_new = false)
    {

        $data = new stdClass();
        if (is_object($admin)) {
            $_POST = array(
                'username' => $admin->getUsername(),
                'password' => $admin->getPassword(),
                'first_name' => $admin->getFirstName(),
                'last_name' => $admin->getLastName(),
                'email' => $admin->getEmail()
            );
            $flashdata = $this->session->flashdata('admin-' . $admin->getId());
            if (empty($flashdata) === false) {
                $_POST = array_merge($_POST, $flashdata);
            }
        } else {
            $_POST = $this->session->flashdata('admin-');
        }
        $data->admin = $admin;
        $data->add_new = $add_new;
        $data->content = $this->prepareView('x_admin', 'form', $data);
        $this->load->view('form', $data);
    }

    public function save(){

        $admin_id = $this->input->post('id');

        if ($this->form_validation->run('admin') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $admin_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        //check if username and email unique
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $is_unique = $this->admin_model->is_unique_username_and_email($username, $email, $admin_id);

        if ($is_unique === false) {
            $this->notificationlib->set('Username and/or email addres already exist', Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('user-' . $admin_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $admin_data = new stdClass();
        if (empty($admin_id) === true) {
            $password = $this->adminlib->generatePassword();
            $admin_data->password = md5($password);
        }
        $admin_data->username = $this->input->post('username');
        $admin_data->first_name = $this->input->post('first_name');
        $admin_data->last_name = $this->input->post('last_name');
        $admin_data->email = $this->input->post('email');
        $admin = $this->admin_model->save($admin_data, $admin_id);


        /*
         * Send e-mail to new admin with link to admin and admin params
         * */

        if(ENVIRONMENT != 'development' && empty($admin_id) === false){

            $link_to_admin = base_url();

            $subject = "[INFO CLASSCOMPETE] Admin panel";

            $headers = '';
            $headers .= 'From: info@classcompete.com' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $email = "<p>Hi $admin_data->first_name $admin_data->last_name,</p>
                      <p>Your account for classcompete admin panel was created</p>
                      <p>Link to admin : $link_to_admin</p>
                      <p>Username: <strong>$admin_data->username</strong></p>
                      <p>Password: <strong>$password</strong></p>";

            @mail($admin_data->email, $subject, $email, $headers);

        }

        redirect('admin');
    }

    public function ajax_validation(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        $admin_id = $this->input->post('id');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $is_unique = $this->admin_model->is_unique_username_and_email($username, $email, $admin_id);

        if ($is_unique === false) {
            $error['custom'] = 'Username or email address already exist.';
        }
        else if($this->form_validation->run('admin') === false && $is_unique === true){
            if(form_error('username') != '')
                $error['username'] = form_error('username');
            if(form_error('first_name') != '')
                $error['first_name'] = form_error('first_name');
            if(form_error('last_name') != '')
                $error['last_name'] = form_error('last_name');
            if(form_error('email') != '')
                $error['email'] = form_error('email');

            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));
    }

    public function delete($admin_id)
    {
        if (empty($admin_id) === false && isset($admin_id) === true) {
            $admin = $this->admin_model->delete($admin_id);
            redirect('admin');
        } else {
            redirect('admin');
        }
    }

    public function profile()
    {
        $data = new stdClass();

        $this->admin_model->excludeById(AdminHelper::get_admin_id());
        $data->table = $this->mapperlib->generate_table(true);

        $data->content = $this->prepareView('x_admin', 'profile', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function password_update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_password', 'Username is required', 'required|xss_clean|trim');
        $this->form_validation->set_rules('password1', 'First name is required', 'required|xss_clean|trim');
        $this->form_validation->set_rules('password2', 'Last name is required', 'required|xss_clean|trim');

        $current_user = $this->session->userdata('userdata');
        $admin_id = $current_user->getId();
        if ($this->form_validation->run() === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $admin_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $old_password = $this->input->post('old_password');
            $admin = $this->admin_model->get_admin_by_id($admin_id);

            if ($admin->getPassword() === md5($old_password)) {
                if ($this->input->post('password1') === $this->input->post('password2')) {
                    $data = new stdClass();
                    $data->password = md5($this->input->post('password1'));

                    $this->admin_model->save($data, $admin_id);

                    redirect('admin');
                } else {
                    // error message: password1 and password2 are different
                }
            } else {
                // error message: your old password is not the same as one in the db
            }
        }

    }
}