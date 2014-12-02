<?php
class Connection extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('y_subscriber/subscriberlib');
        $this->load->library('y_connection/connectionlib');
        $this->load->library('y_user/parentlib');
        $this->load->library('y_user/studentlib');
        $this->load->library('y_connection/connectionlib');
//        $this->load->library('y_mailer/mailerlib');

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_post()
    {
        $_POST = $this->post();
        $error = array();

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        $out = new stdClass();

        if ($this->form_validation->run() === false) {
            if (form_error('email') != '') {
                $error['email'] = form_error('email');
            }
            if (form_error('username') != '') {
                $error['username'] = form_error('username');
            }
            if (form_error('password') != '') {
                $error['password'] = form_error('password');
            }
            $this->response($error, 400);
        } else {
            $data = new stdClass();
            $data->email = $this->post('email');
            $data->username = $this->post('username');
            $data->password = $this->post('password');

            $subscriber_exists = $this->subscriberlib->subscriber_exists($data->email);

            if ($subscriber_exists === false) {
                $error['subscriber'] = 'Subscriber with email ' . $data->email . ' does not exist.';
            } else {

                // check if student exists by username
                $student = $this->studentlib->check_if_student_exists_by_username($data->username);

                if ($student === false) {
                    $error['student'] = 'Student with username ' . $data->username . ' does not exist.';
                } else {
                    $login = $this->studentlib->check_if_password_belongs_to_username($data->username, $data->password);
                    if ($login === false) {
                        $error['student_login'] = 'Student username and password does not match';
                    } else {
                        //check if student already connected to some parent
                        $student_connected = $this->connectionlib->check_if_student_connected_with_some_parent($student->getStudentId());

                        if ($student_connected === true) {
                            $error['student_connected'] = 'Student already connected with parent';
                        }
                    }
                }
            }

            // everything ok, making new user account for parent with student password and making parent student connection
            if (empty($error) === true) {

                $parent_exists = $this->parentlib->check_if_parent_exists_by_email($data->email);

                if (empty($parent_exists) === true) {
                    // making new parent account
                    $parent_data = new stdClass();
                    $parent_data->username = $data->email;
                    $parent_data->email = $data->email;
                    $parent_data->password = md5($data->password);
                    $parent_data->first_name = '';
                    $parent_data->last_name = '';

                    $parent = $this->parent_model->save($parent_data);

                    $parent_object = $this->parent_model->get_parent_id_by_user_id($parent->getUserId());
                } else {
                    $parent_object = $this->parent_model->get_parent_id_by_user_id($parent_exists->getUserId());
                }

                // making new parent - student connection
                $connection_data = new stdClass();
                $connection_data->parent_id = $parent_object->getParentId();
                $connection_data->student_id = $student->getStudentId();

                $connection = $this->connection_model->save($connection_data);

                if (empty($connection) === false) {
                    $out->status = 'Congratulations!  You have been connected to your student';
                } else {
                    $out->status = 'error';
                }
            } else {
                $out = $error;
            }

        }

        $this->response($out);
    }

    public function id_delete($id)
    {
        $delete = $this->connection_model->delete_by_id($id);

        $out = new stdClass();

        if ($delete === null){
            $out->deleted = false;
        } else {
            $out->deleted = $delete;
        }

        $this->response($out);
    }
}