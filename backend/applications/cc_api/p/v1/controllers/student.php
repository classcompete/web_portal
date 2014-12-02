<?php
class Student extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('p_child/childlib');
        $this->load->library('y_user/studentlib');
        $this->load->library('y_connection/connectionlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

    }

    public function index_get(){
        $data = new stdClass();

        $data->child = array();

        $children = $this->child_model->getList();

        foreach($children as $child=>$val){
            $data->child[$child]['first_name'] = $val->getPropStudent()->getPropUser()->getFirstName();
            $data->child[$child]['last_name'] = $val->getPropStudent()->getPropUser()->getLastName();
            $data->child[$child]['name'] = $val->getPropStudent()->getPropUser()->getFirstName() .' '.$val->getPropStudent()->getPropUser()->getLastName();
            $data->child[$child]['student_id'] = $val->getPropStudent()->getStudentId();
        }

        $this->response($data);
    }

    public function index_post(){
        $_POST = $this->post();
        $error = array();

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        $out = new stdClass();

        if ($this->form_validation->run() === false) {
            if (form_error('username') != '') {
                $error['username'] = form_error('username');
            }
            if (form_error('password') != '') {
                $error['password'] = form_error('password');
            }
            $this->response($error, 400);
        } else {
            $data = new stdClass();
            $data->username = $this->post('username');
            $data->password = $this->post('password');

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

            if(empty($error) === true){
                // making new parent - student connection
                $connection_data = new stdClass();
                $connection_data->parent_id = ParentHelper::getId();
                $connection_data->student_id = $student->getStudentId();

                $connection = $this->connection_model->save($connection_data);

                if (empty($connection) === false) {
                    $out->status = 'success';
                }
            }else{
                $out = $error;
            }

        }

        if(empty($error) === false){
            $this->response($out,400);
        }
        $this->response($out);
    }

}