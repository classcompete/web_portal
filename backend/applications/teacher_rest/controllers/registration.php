<?php
class Registration extends REST_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library('y_user/teacherlib');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_post(){

        $_POST = $this->post();
        $error = array();
        if ($this->form_validation->run('teacher_registration') === false) {
            if (form_error('username') != '') {
                $error['username'] = form_error('username');
            }
            if (form_error('first_name') != '') {
                $error['first_name'] = form_error('first_name');
            }
            if (form_error('last_name') != '') {
                $error['last_name'] = form_error('last_name');
            }
            if (form_error('email') != '') {
                $error['email'] = form_error('email');
            }
            if (form_error('password') != '') {
                $error['password'] = form_error('password');
            }
            if (form_error('re_password') != '') {
                $error['re_password'] = form_error('re_password');
            }
            if (form_error('terms_and_policy') != '') {
                $error['terms_and_policy'] = form_error('terms_and_policy');
            }
            $this->response($error, 400);
        }


        $check = $this->teacher_model->check_data_for_registration($_POST);

        if ($check->username === false || $check->email === false) {
            if($check->username === false){
                $error['username'] = 'Username is already taken!';
            }
            if($check->email === false){
                $error['email'] = 'Email address is already taken!';
            }
            $this->response($error, 400);
        }


        $grades             = $this->input->post('grade');
        $password           = $this->input->post('password');

        $data               = new stdClass();
        $data->grades       = new stdClass();
        $data->username     = $this->post('username');
        $data->first_name   = $this->post('first_name');
        $data->last_name    = $this->post('last_name');
        $data->email        = $this->post('email');

        $data->password     = md5($password);

        $listed_school      = $this->post('not_listed');

        if (isset($listed_school) === true && empty($listed_school) === false) {
            $data->zip_code = $this->post('zip_code');
            $data->school_name = $this->post('school_name');
        } else {
            $data->school_id = $this->post('school_id');
        }


        if (isset($grades) === true && empty($grades) === false) {
            foreach ($grades as $grades => $val) {
                switch($grades){
                    case 'pre_k':
                        $data->grades->$grades = -2;
                        break;
                    case 'grade_k':
                        $data->grades->$grades = -1;
                        break;
                    case 'grade_first':
                        $data->grades->$grades = 1;
                        break;
                    case 'grade_second':
                        $data->grades->$grades = 2;
                        break;
                    case 'grade_third':
                        $data->grades->$grades = 3;
                        break;
                    case 'grade_fourth':
                        $data->grades->$grades = 4;
                        break;
                    case 'grade_fifth':
                        $data->grades->$grades = 5;
                        break;
                    case 'grade_sixth':
                        $data->grades->$grades = 6;
                        break;
                    case 'grade_seventh':
                        $data->grades->$grades = 7;
                        break;
                    case 'grade_eight':
                        $data->grades->$grades = 8;
                        break;
                }
            }
        }
        $fp = fopen(X_TEACHER_IMAGES_PATH . '/' . 'profile.png', 'r');
        $data->avatar = base64_encode(fread($fp, filesize(X_TEACHER_IMAGES_PATH . '/' . 'profile.png')));
        fclose($fp);

        $teacher = $this->teacher_model->save($data, null);

        try {
            $user = $this->teacherlib->_login($data->username, $password);
        } catch (Exception $e) {
            $this->response(array($e->getMessage()), 400);
        }

        $auth_data = new stdClass();

        $auth_data->user_data = $this->teacherlib->set_teacherlogin($user);

        $this->response($auth_data, 200);
    }

}