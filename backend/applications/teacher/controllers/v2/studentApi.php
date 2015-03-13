<?php

class StudentApi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        if (TeacherHelper::is_teacher() === false) {
            return $this->jsonOutput(array('error' => 'You have to be logged in to do this'), 401, 'Unauthorized');
        }
    }

    public function profilePut()
    {
        if (empty($_POST) === true) {
            return $this->jsonOutput(array('error' => 'Request can\'t be processed'), 405, 'Method not allowed');
        }
        $userId = intval($this->input->post('user_id'));
        $user = PropUserQuery::create()
            ->joinPropStudent()
            ->findOneByUserId($userId);
        if (empty($user) === true) {
            return $this->jsonOutput(array('error' => 'Can\'t save this data', 'extended' => array('Unknown user')), 400);
        }
        $student = $user->getPropStudent();

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('parent_email', 'Email', 'trim|valid_email');

        if ($this->form_validation->run() === false) {
            $errors = array();
            foreach (array('username', 'email', 'first_name', 'last_name', 'parent_email') as $name) {
                $single = $this->form_validation->error($name, ' ', ' ');
                if (empty($single) === false) {
                    array_push($errors, trim($single));
                }
            }
            return $this->jsonOutput(array('error' => 'Required fields are missing', 'extended' => $errors), 400);
        }

        //is username unique
        $usernameCheck = PropUserQuery::create()
            ->joinPropStudent()
            ->filterByUserId($user->getId(), Criteria::NOT_EQUAL)
            ->filterByLogin($this->input->post('username'))
            ->findOne();
        if (empty($usernameCheck) === false) {
            return $this->jsonOutput(array('error' => 'Can\'t save this data', 'extended' => array('Username already in use')), 400);
        }

        /*$emailCheck = PropUserQuery::create()
            ->joinPropStudent()
            ->filterByUserId($user->getId(), Criteria::NOT_EQUAL)
            ->filterByEmail($this->input->post('email'))
            ->findOne();
        if (empty($emailCheck) === false) {
            return $this->jsonOutput(array('error' => 'Can\'t save this data', 'extended' => array('Email already in use')), 400);
        }*/

        //update user if reached this point
        $user->setFirstName($this->input->post('first_name'));
        $user->setLastName($this->input->post('last_name'));
        $user->setLogin($this->input->post('username'));
        $user->setEmail($this->input->post('email'));
        $user->save();

        $parentEmail = $this->input->post('parent_email');
        if (empty($parentEmail) === false) {
            $student->setParentEmail($parentEmail);
            $student->save();
        }
        return $this->jsonOutput(array('success' => true), 200);
    }

    protected function jsonOutput($data, $code = 200, $message = '')
    {
        return $this->output
            ->set_status_header($code, $message)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}