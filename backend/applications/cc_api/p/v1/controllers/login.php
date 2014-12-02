<?php
class Login extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('y_user/parentlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_post()
    {
        $_POST = $this->post();
        $error = array();

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === false) {
            if (form_error('username') != '')
                $error['username'] = form_error('username');
            if (form_error('password') != '')
                $error['password'] = form_error('password');
            $this->response($error, 400);
        }

        $username = $this->post('username');
        $password = $this->post('password');

        try {
            $user = $this->parentlib->_login($username, $password);
        } catch (Exception $e) {
            $error['redirect'] = $e->getMessage();
            $this->response($error, 400);

        }
        $teacher_auth_code = $this->parentlib->set_parentlogin($user);

        $data['user_data'] = $teacher_auth_code;
        $this->response($data, 200);
    }

    public function index_get()
    {
        $data = array();

        if (ParentHelper::is_parent_rest() === true) {
            $data['logged'] = true;
            $data['parent_image'] = $this->config->item('images_url') . 'parent_image/parent/' . ParentHelper::getUserId();
            $this->response($data, 200);
        } else {
            $data['logged'] = false;
            $this->response($data, 401);
        }
    }

}