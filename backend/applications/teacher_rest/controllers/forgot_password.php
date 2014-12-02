<?php
class Forgot_password extends REST_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library('y_user/teacherlib');
        $this->load->library('y_mailer/mailerlib');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_post()
    {
        $_POST = $this->post();

        $email = $this->post('email');
        $error = array();

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

        if ($this->form_validation->run() === false) {
            if (form_error('email') != '') {
                $error['error'] = form_error('email');
            }
            $error['validation'] = false;
            $this->response($error, 400);
        } else {
            try {
                $check = $this->teacherlib->check_email($email);
            } catch (Exception $e) {
                $error['error'] = $e->getMessage();
                $error['validation'] = false;
                $this->response($error, 400);
            }
        }

        if (empty($error) === true) {
            $error['validation'] = true;
            $this->teacherlib->reset_password($email);
        }


        $this->response($error);
    }

}