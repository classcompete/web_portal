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

    public function login()
    {
        $data = new stdClass();
        $data->form_data = $this->session->flashdata('login_form');
        $_POST = $data->form_data;
        $this->load->view(config_item('teacher_template') . '_login', $data);
    }

    public function process_login()
    {

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === false) {
            $error = $this->login_validation();
            $this->session->set_flashdata('error', json_decode($error));
            var_dump($error);
            die;
            redirect('auth/login_error');
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $remember_me = (bool)$this->input->post('remember_me');

        try {
            $user = $this->teacherlib->_login($username, $password);
        } catch (Exception $e) {
            $this->notificationlib->setFailure($e->getMessage());
            $error = $this->login_validation();
            $this->session->set_flashdata('error', json_decode($error));
            redirect('auth/login_error');

        }
        $this->teacherlib->set_teacherlogin($user);

        if ($remember_me === true) {
            $this->teacherlib->set_autologin($user, 86400);
        }

        redirect();
    }

    /**
     *  Function to register teacher and autologin
     * */
    public function process_register()
    {

        if ($this->form_validation->run('teacher_registration') === false) {
            redirect();
        }
        $check = $this->teacher_model->check_data_for_registration($_POST);
        if ($check->username === false || $check->email === false) {
            redirect();
        }

        $grades = $this->input->post('grade');
        $password = $this->input->post('password');
        $data = new stdClass();
        $data->grades = new stdClass();
        $data->username = $this->input->post('username');
        $data->first_name = $this->input->post('first_name');
        $data->last_name = $this->input->post('last_name');
        $data->email = $this->input->post('email');

        $data->password = md5($password);

        $listed_school = $this->input->post('not_listed');

        if (isset($listed_school) === true && empty($listed_school) === false) {
            $data->zip_code = $this->input->post('zip_code');
            $data->school_name = $this->input->post('school_name');

            // send mail to Rahul to knew that new school is added
            $emailData = new stdClass();
            $emailData->school_name = $data->school_name;
            $emailData->zip_code = $data->zip_code;
            if (ENVIRONMENT != 'development') {
                $this->send_mail_inform_new_school($emailData);
            }
        } else {
            $data->school_id = $this->input->post('school_id');
        }

        if (isset($grades) === true && empty($grades) === false) {
            foreach ($grades as $grades => $val) {
                $data->grades->$grades = $grades;
            }
        }

        $fp = fopen(X_TEACHER_IMAGES_PATH . '/' . 'profile.png', 'r');
        $data->avatar = base64_encode(fread($fp, filesize(X_TEACHER_IMAGES_PATH . '/' . 'profile.png')));
        fclose($fp);

        $data->country = $this->input->post('country');

        $teacher = $this->teacher_model->save($data, null);

        try {
            $user = $this->teacherlib->_login($data->username, $password);
        } catch (Exception $e) {
            $this->notificationlib->setFailure($e->getMessage());
            redirect('auth/login');

        }
        $this->teacherlib->set_teacherlogin($user);

        $newUserData = new stdClass();
        $newUserData->email = $data->email;
        $this->send_mail_to_new_registered_user($newUserData);

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

        redirect();
    }

    public function  ajax_validate_registration()
    {
        $error = array();
        $this->form_validation->set_error_delimiters('', '');


        if ($this->form_validation->run('teacher_registration') === false) {

            if (form_error('username') != '')
                $error['username'] = form_error('username');
            if (form_error('first_name') != "")
                $error['first_name'] = form_error('first_name');
            if (form_error('last_name') != "")
                $error['last_name'] = form_error('last_name');
            if (form_error('email') != "")
                $error['email'] = form_error('email');
            if (form_error('password') != "")
                $error['password'] = form_error('password');
            if (form_error('re_password') != "")
                $error['re_password'] = form_error('re_password');
            if (form_error('terms_and_policy') !== "")
                $error['terms_and_policy'] = form_error('terms_and_policy');
            $check = $this->teacher_model->check_data_for_registration($_POST);
            if ($check->username === false) {
                $error['username_taken'] = 'Username is already taken';
            }
            if ($check->email === false) {
                $error['email_taken'] = 'Email address is already taken';
            }
            $this->output->set_status_header('400');
        } else {
            $check = $this->teacher_model->check_data_for_registration($_POST);
            if ($check->username === false || $check->email === false) {
                if ($check->username === false) {
                    $error['username_taken'] = 'Username is already taken';
                }
                if ($check->email === false) {
                    $error['email_taken'] = 'Email address is already taken';
                }
                $this->output->set_status_header('400');
            } else {
                $error['validation'] = true;
            }
        }

        $school_id = $this->input->post('school_id');
        $school_listed = $this->input->post('not_listed');
        if (empty($school_id) === true && empty($school_listed) === true) {
            $error['not_listed_school'] = 'My school is not listed is required field';
        }

        $this->output->set_output(json_encode($error));

    }

    public function forgot_password()
    {
        $data = new stdClass();
        $data->form_data = $this->session->flashdata('login_form');
        $_POST = $data->form_data;
        $this->load->view(config_item('teacher_template') . '_forgot_password', $data);
    }

    public function reset_password()
    {

        $email = $this->input->post('email');

        $check = array();

        /*
         * Check if we have teacher with that email
         * */
        try {
            $check = $this->teacherlib->check_email($email);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', json_encode($e->getMessage()));
            redirect('auth/forgot_password');
        }

        if (empty($check) === false) {
            $password = $this->teacherlib->generatePassword();
            $check->setPassword(md5($password));

            /*
             * Update admin password
             * */
            $new_data = new stdClass();
            $new_data->password = $check->getPassword();

            $this->teacher_model->save($new_data, $check->getId());

            $data = new stdClass();
            $data->first_name = $check->getFirstName();
            $data->last_name = $check->getLastName();
            $data->email = $check->getEmail();

            $this->session->set_flashdata('message', 'Check your email for new password');

            if (ENVIRONMENT != 'development') {
                $this->send_mail_to_teacher_forgot_password(config_item('teacher_url'), $data, $password);
            }
        }
        redirect('auth/login');
    }

    public function ajax_validate_forgot_password()
    {
        $email = $this->input->post('email');
        $error = array();

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('email', 'Email', 'required|trim');

        if ($this->form_validation->run() === false) {
            if (form_error('email') != '') {
                $error['error'] = form_error('email');
            }
            $this->output->set_status_header('400');
            $error['validation'] = false;
        } else {
            try {
                $check = $this->teacherlib->check_email($email);
            } catch (Exception $e) {
                $error['error'] = $e->getMessage();
                $error['validation'] = false;
                $this->output->set_status_header('400');
            }
        }

        if (empty($error) === true) {
            $error['validation'] = true;
        }

        $this->output->set_output(json_encode($error));
    }

    public function register()
    {
        $countryList = PropCountryQuery::create()->filterByStatus(PropCountryPeer::STATUS_ACTIVE)->orderByName(Criteria::ASC)->find();
        $data = new stdClass();
        $data->countryList = $countryList;


        $this->load->view(config_item('teacher_template') . '_register', $data);
    }


    /*
     * Send email for new teacher
     * */

    private function send_mail_to_new_registered_user($data)
    {
        $subject = "INFO CLASSCOMPETE Teacher panel";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>
                    Congratulations!!! You have registered for Class Compete, where your students will improve test
                    taking skills and improve test scores while having fun!</p>
                  <p>To login to the teacher portal please <a href='http://teacher.classcompete.com'>Click Here</a></p>
                  <p><i>Thank you for being part of this trial.</i></p>
                  <p>
                    <i>
                        If you would like further information about what Class Compete can offer you and your school
                        please visit our website. <a href='www.classcompete.com'>www.classcompete.com</a>.
                        By chance if you are receiving this email in error or wish to revoke access to this system,
                        please email: <a href='mailto:moreinfo@classcompete.com'>moreinfo@classcompete.com</a>
                    </i>
                </p>";
        @mail($data->email, $subject, $email, $headers);
    }

    /*
    *
    * Sed e-mail to user for password forgot
    * */
    private function send_mail_to_teacher_forgot_password($link_to_site, $data, $password)
    {

        $subject = "INFO CLASSCOMPETE Teacher panel";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>You have requested your password for Class Compete to be reset. <br/>Please see below for your current password and try to login again.
                     If you still have problems please email: <a href='mailto:moreinfo@classcompete.com'>moreinfo@classcompete.com</a></p>
                    <p>New password: <strong>$password</strong></p>";
        $mailSent = @mail($data->email, $subject, $email, $headers);
    }

    /*
     *
     * Sed e-mail to user for password forgot
     * */
    private function send_mail_inform_new_school($data)
    {

        $subject = "NEW SCHOOL IS ADDED";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>Hi,</p>
                  <p>New school is added.</p>
                  <p>School name: <strong>$data->school_name</strong>, <strong>Zip-code: $data->zip_code</strong></p>
                  <p>Regards</p>";


        $cc = array('rahul@classcompete.com', 'darko.lazic@codeanvil.co');

        foreach ($cc as $mail) {
            @mail($mail, $subject, $email, $headers);
        }
    }

    public function ajax_validation_login()
    {
        $this->load->library('form_validation');

        $error = array();

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === false) {
            if (form_error('username') != '') {
                $error['username'] = form_error('username');
            }
            if (form_error('password') != '') {
                $error['password'] = form_error('password');
            }
            $this->output->set_status_header('400');

        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            try {
                $user = $this->teacherlib->_login($username, $password);
                $error['validation'] = true;
                $this->output->set_status_header('200');
            } catch (Exception $e) {
                $this->notificationlib->setFailure($e->getMessage());
                $error['message'] = $e->getMessage();
                $this->output->set_status_header('400');
            }
        }
        $this->output->set_output(json_encode($error));
    }

    private function login_validation()
    {

        $this->load->library('form_validation');

        $error = array();

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === false) {
            if (form_error('username') != '') {
                $error['username'] = form_error('username');
            }
            if (form_error('password') != '') {
                $error['password'] = form_error('password');
            }
            $this->output->set_status_header('400');

        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            try {
                $user = $this->teacherlib->_login($username, $password);
                $error['validation'] = true;
                $this->output->set_status_header('200');
            } catch (Exception $e) {
                $this->notificationlib->setFailure($e->getMessage());
                $error['message'] = $e->getMessage();
                $this->output->set_status_header('400');
            }
        }
        return json_encode($error);
    }


    public function process_logout()
    {
        $this->teacherlib->unset_teacherlogin();
        $this->teacherlib->unset_autologin();
        redirect();
    }

    public function login_error()
    {
        $this->load->view('login_error');
    }

    public function ajax_school()
    {
        $school = $this->input->post('school');

        $query = $this->school_model->find_school($school['school'], $school['zip_code']);


        $this->output->set_output(json_encode($query));

    }
}