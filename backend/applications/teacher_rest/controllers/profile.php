<?php
class Profile extends REST_Controller
{

    public function __construct()
    {
        parent:: __construct();

        $this->load->library('y_user/teacherlib');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');



    }
    public function index_get(){
        $data = new stdClass();

        $teacher_info = $this->teacher_model->get_teacher_info(TeacherHelper::getUserId());

        $data->teacher_info['teacher_id']   = $teacher_info->getTeacherId();
        $data->teacher_info['first_name']   = $teacher_info->getPropUser()->getFirstName();
        $data->teacher_info['last_name']    = $teacher_info->getPropUser()->getLastName();
        $data->teacher_info['email']        = $teacher_info->getPropUser()->getEmail();
        $data->teacher_info['user_id']      = $teacher_info->getUserId();
        $data->teacher_info['image_thumb']  = $this->config->item('images_url') . 'teacher/' . $teacher_info->getUserId();
        $data->teacher_info['school_id']    = $teacher_info->getSchoolId();
        $data->teacher_info['biography']    = $teacher_info->getBiography();

        if($teacher_info->getSchoolId() !== 0){
            $data->teacher_info['zip_code']     = $teacher_info->getPropSchool()->getZipCode();
            $data->teacher_info['school_name']   = $teacher_info->getPropSchool()->getName();
        }

        $grades = $this->teacher_model->get_teacher_grades(TeacherHelper::getId());
        $data->teacher_grades = new stdClass();

        foreach ($grades as $grade => $val) {
            switch ($val->getGrade()) {
                case -2:
                    $data->teacher_grades->grade_pre_k = true;
                    break;
                case -1:
                    $data->teacher_grades->grade_k = true;
                    break;
                case 1:
                    $data->teacher_grades->grade_first = true;
                    break;
                case 2:
                    $data->teacher_grades->grade_second = true;
                    break;
                case 3:
                    $data->teacher_grades->grade_third = true;
                    break;
                case 4:
                    $data->teacher_grades->grade_fourth = true;
                    break;
                case 5:
                    $data->teacher_grades->grade_fifth = true;
                    break;
                case 6:
                    $data->teacher_grades->grade_sixth = true;
                    break;
                case 7:
                    $data->teacher_grades->grade_seventh = true;
                    break;
                case 8:
                    $data->teacher_grades->grade_eight = true;
                    break;
            }
        }

        $this->response($data);
    }

    public function index_put()
    {
        $_POST = $this->put();

        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Lirst Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('bio', 'Biography', 'trim');

        $user_id = TeacherHelper::getUserId();
        $out = new stdClass();

        if ($this->form_validation->run() === false) {
            $error = REST_Form_validation::validation_errors_array();

            $this->response($error, 400);
        } else {
            $first_name = $this->put('first_name');
            $last_name = $this->put('last_name');
            $email = $this->put('email');
            $avatar = $this->put('teacher_avatar_url');
            $biography = $this->put('biography');
            $grades = $this->put('grades');

            $data = new stdClass();
            $data->grades = new stdClass();
            if (empty($first_name) === false) {
                $data->first_name = $first_name;
            }
            if (empty($last_name) === false) {
                $data->last_name = $last_name;
            }
            if (empty($email) === false) {
                $data->email = $email;
            }
            if (empty($avatar) === false) {

                $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . trim($avatar);
                $fp = fopen($img_link, 'r');

                $data->avatar = base64_encode(fread($fp, filesize($img_link)));
                fclose($fp);
            }
            if (empty($biography) === false) {
                $data->biography = $biography;
            }

            if (isset($grades) === true && empty($grades) === false) {
                foreach ($grades as $grades => $val) {
                    switch($grades){
                        case 'grade_pre_k':
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

//            $out->teacher = $this->teacher_model->save($data, $user_id);



            // password change
            $old_password = $this->put('old_password');
            $new_password = $this->put('new_password');
            $password2 = $this->put('re_new_password2');

            if (!(empty($old_password) === true && empty($new_password) === true && empty($password2) === true)) {
                $this->form_validation->set_rules('old_password', 'Old Password', 'required|trim','callback_check_password_in_db');
                $this->form_validation->set_rules('new_password', 'Password', 'required|trim');
                $this->form_validation->set_rules('re_new_password', 'Password Confirmation', 'required|trim|matches[new_password]');

                if ($this->form_validation->run() === false) {
                    $error = REST_Form_validation::validation_errors_array();
                    $this->response($error, 400);

                } else {
                    $teacher = $this->teacher_model->get_user_by_id(TeacherHelper::getUserId());

                    if($teacher->getPassword() !== md5($old_password)){
                        $error['old_password'] = 'The Old Password field does not match the Password in our system.';
                        $this->response($error, 400);
                    }
                }
                $data->password = md5($new_password);

            }

            // change school
            $zip_code = $this->put('zip_code');
            $school_name = $this->put('school_name');

            if (!(empty($zip_code) === true && empty($school_name) === true)){
                $this->form_validation->set_rules('zip_code', 'Zip code', 'required|trim');
                $this->form_validation->set_rules('school_name', 'School name', 'required|trim');

                $listed_school = $this->input->post('not_listed');

                if ($this->form_validation->run() === false) {
                    $error = REST_Form_validation::validation_errors_array();
                    $this->response($error, 400);
                } else {
                    if (isset($listed_school) === true && empty($listed_school) === false) {
                        $data->zip_code = $this->put('zip_code');
                        $data->school_name = $this->put('school_name');
                    } else {
                        $data->school_id = intval($this->put('school_id'));
                    }

                    $out->school = $this->teacher_model->change_school($data);

                }
            }
        }
        $out->teacher = $this->teacher_model->save($data, $user_id);
        $this->response($out);
    }

}