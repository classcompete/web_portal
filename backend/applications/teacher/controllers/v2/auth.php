<?php

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('x_school/school_model');

        if (TeacherHelper::is_teacher() === true && $this->uri->segment(2) !== 'process_logout') {
            redirect(base_url());
        }
    }

    public function index()
    {
        $this->load->view('v2/home');
    }

    public function registerPost()
    {
        if (empty($_POST) === true) {
            return $this->jsonOutput('', 405, 'Method not allowed');
        }


        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === false) {
            $errors = array();
            foreach (array('email', 'password', 'first_name', 'last_name') as $name) {
                $single = $this->form_validation->error($name, ' ', ' ');
                if (empty($single) === false) {
                    array_push($errors, trim($single));
                }
            }
            return $this->jsonOutput(array('error' => 'All fields are mandatory', 'extended' => $errors), 400);
        }

        // additional password length validation
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
        if ($this->form_validation->run() === false) {
            return $this->jsonOutput(array('error' => 'Password has to be at least 6 characters long'), 400);
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        if ($this->form_validation->run() === false) {
            return $this->jsonOutput(array('error' => 'Email must contain a valid email address'), 400);
        }

        $check = $this->teacher_model->check_data_for_registration(array(
            'username' => $this->input->post('email'),
            'email' => $this->input->post('email'),
        ));
        if ($check->username === false || $check->email === false) {
            return $this->jsonOutput(array('error' => 'Email is already in use'), 400);
        }

        $password = $this->input->post('password');

        $data = new stdClass();
        $data->username = $this->input->post('email');
        $data->first_name = $this->input->post('first_name');
        $data->last_name = $this->input->post('last_name');
        $data->email = $this->input->post('email');
        $data->password = md5($password);

        $fp = fopen(X_TEACHER_IMAGES_PATH . '/' . 'profile.png', 'r');
        $data->avatar = base64_encode(fread($fp, filesize(X_TEACHER_IMAGES_PATH . '/' . 'profile.png')));
        fclose($fp);

        $teacher = $this->teacher_model->save($data, null);

        $user = $this->teacherlib->_login($data->email, $password);
        $this->teacherlib->set_teacherlogin($user);

        //add to mailchimp
        $this->load->library('mailchimp/mailchimplib');
        $this->mailchimplib->call('lists/subscribe', array(
            'id' => 'b5309bf6ac',
            'email' => array(
                'email' => $data->email
            ),
            'merge_vars' => array(
                'FNAME' => $data->first_name,
                'LNAME' => $data->last_name
            ),
            'double_optin' => false,
            'update_existing' => true,
            'replace_interests' => false,
            'send_welcome' => false,
        ));

        $newAccountData = new stdClass();

        $newAccountData->username = $data->username;
        $newAccountData->password = $password;
        $newAccountData->email = $data->email;

        $this->load->library('mailer/mailerlib');
        $this->mailerlib->sendAccountCreated($newAccountData);

        return $this->jsonOutput(array('success'=>true));

    }

    public function loginPost()
    {
        if (empty($_POST) === true) {
            $this->jsonOutput('', 405, 'Method not allowed');
        }
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === false) {
            $errors = array();
            foreach (array('username', 'password') as $name) {
                $single = $this->form_validation->error($name, ' ', ' ');
                if (empty($single) === false) {
                    array_push($errors, trim($single));
                }
            }
            return $this->jsonOutput(array('error' => 'All fields are mandatory', 'extended' => $errors), 401, 'Login permitted');
        }

        try {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->teacherlib->_login($username, $password);
            $result = array('success' => true);
            $code = 200;
        } catch (Exception $e) {
            $result = array('error' => $e->getMessage());
            $code = 401;
        }

        $this->teacherlib->set_teacherlogin($user);
        return $this->jsonOutput($result, $code);
    }

    protected function jsonOutput($data, $code = 200, $message = '')
    {
        return $this->output
            ->set_status_header($code, $message)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}