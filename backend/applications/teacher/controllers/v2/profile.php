<?php

class Profile extends MY_Controller
{
    protected $profileData;

    public function __construct()
    {
        parent:: __construct();

        $this->load->model('x_users/teacher_model');
        $this->load->library('x_plupload/pluploadlib_new');
        $this->load->model('x_school/school_model');
        $this->load->library('x_timezone/timezonelib');

        $this->formData = new stdClass();
    }

    public function ajax_school(){
        $school = $this->input->post('school');
        $query = $this->school_model->find_school($school['school'], $school['zip_code']);
        $this->output->set_output(json_encode($query));
        return;
    }

    public function password()
    {
        $data = new stdClass();

        $data->content = $this->load->view('v1.5/profile/password', $data, true);
        $this->load->view('compete', $data);
    }

    public function publisher()
    {
        $data = new stdClass();

        $profileData = $this->teacher_model->get_teacher_info(TeacherHelper::getUserId());

        $data->profileData = $profileData;

        $data->content = $this->load->view('v1.5/profile/publisher', $data, true);
        $this->load->view('compete', $data);
    }

    public function index()
    {
        $grades = $this->teacher_model->get_teacher_grades(TeacherHelper::getId());
        $timezones = $this->timezone_model->getList();
        $countryList = PropCountryQuery::create()->filterByStatus(PropCountryPeer::STATUS_ACTIVE)->orderByName(Criteria::ASC)->find();

        $data = new stdClass();

        $data->teacherGrades = $this->makeGradesMatrix($grades);
        $data->userProfile = PropUserQuery::create()->findOneByUserId(TeacherHelper::getUserId());
        $data->teacherProfile = PropTeacherQuery::create()->findOneByUserId(TeacherHelper::getUserId());
        $data->timezones = $timezones;
        $data->countryList = $countryList;
        $data->profileData = $this->profileData;

        $data->content = $this->load->view('v1.5/profile/general', $data, true);
        $this->load->view('compete', $data);
    }

    public function makeGradesMatrix($grades)
    {
        $teacherGrades = new stdClass();
        foreach ($grades as $grade => $val) {
            switch ($val->getGrade()) {
                case -2:
                    $teacherGrades->grade_pre_k = true;
                    break;
                case -1:
                    $teacherGrades->grade_k = true;
                    break;
                case 1:
                    $teacherGrades->grade_1 = true;
                    break;
                case 2:
                    $teacherGrades->grade_2 = true;
                    break;
                case 3:
                    $teacherGrades->grade_3 = true;
                    break;
                case 4:
                    $teacherGrades->grade_4 = true;
                    break;
                case 5:
                    $teacherGrades->grade_5 = true;
                    break;
                case 6:
                    $teacherGrades->grade_6 = true;
                    break;
                case 7:
                    $teacherGrades->grade_7 = true;
                    break;
                case 8:
                    $teacherGrades->grade_8 = true;
                    break;
                case 9:
                    $teacherGrades->high_school = true;
                    break;
                case 10:
                    $teacherGrades->higher_ed = true;
                    break;
            }
        }

        return $teacherGrades;
    }

    public function generalProfilePut()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('country', 'Country', 'required|trim');
        $this->form_validation->set_rules('grade', 'Grades', 'required');

        if ($this->form_validation->run() === false) {
            $errors = array();
            foreach (array('first_name', 'last_name', 'email', 'country', 'grade') as $name) {
                $single = $this->form_validation->error($name, ' ', ' ');
                if (empty($single) === false) {
                    switch($name) {
                        case 'grade':
                            $message = 'You need to select at least one grade you are teaching';
                            break;
                        default: $message = trim($single);
                    }
                    array_push($errors, $message);
                }
            }
            return $this->jsonOutput(array('error' => 'All fields are mandatory', 'extended' => $errors), 400, 'Bad Data');
        }

        // check is mail still unique
        $email = $this->input->post('email');
        $uniqueEmail = $this->teacher_model->is_unique_username_and_email($email, $email, TeacherHelper::getUserId());
        if ($uniqueEmail === false) {
            return $this->jsonOutput(array('error' => 'Email you provided already registered for another user'), 400, 'Bad Data');
        }

        //update school data
        $this->form_validation->set_rules('zip_code', 'School Zip Code', 'required|trim');
        $this->form_validation->set_rules('school_name', 'School Name', 'required|trim');
        if($this->form_validation->run() === false){
            foreach (array('zip_code', 'school_name') as $name) {
                $single = $this->form_validation->error($name, ' ', ' ');
                if (empty($single) === false) {
                    switch($name) {
                        default: $message = trim($single);
                    }
                    array_push($errors, $message);
                }
            }
            return $this->jsonOutput(array('error' => 'You need to provide valid school details', 'extended' => $errors), 400, 'Bad Data');
        }

        $schoolNotListed = $this->input->post('not_listed');
        if (intval($this->input->post('school_id') <= 0) && empty($schoolNotListed) === true) {
            return $this->jsonOutput(array('error' => 'You have to select "My School is Not Listed" Checkbox to proceed with updating your profile'), 400, 'Bad Data');
        }

        $userData = new stdClass();

        //user data
        $userData->first_name = $this->input->post('first_name');
        $userData->last_name = $this->input->post('last_name');
        $userData->username = $this->input->post('email');
        $userData->email = $this->input->post('email');
        //teacher data
        $userData->country = $this->input->post('country');
        $userData->twitter_name = $this->input->post('twitter_name');
        $userData->facebook_link = $this->input->post('facebook_link');
        $userData->time_diff = $this->input->post('timezone');

        //reformat grades
        $gradesSelected = $this->input->post('grade');
        if(empty($gradesSelected) === false){
            foreach($gradesSelected as $grade => $val){
                $userData->grades->$grade = $grade;
            }
        }
        //prepare school details
        if (empty($schoolNotListed) === false) {
            // we have new school
            $userData->zip_code = $this->input->post('zip_code');
            $userData->school_name = $this->input->post('school_name');
        }  else {
            //existing school - just update
            $userData->school_id    = $this->input->post('school_id');
        }

        $this->teacher_model->save($userData, TeacherHelper::getUserId());

        return $this->jsonOutput(array('success'=>true));
    }

    public function passwordPut()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_password', 'Old Password', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('new_password', 'Password Confirmation', 'required|trim');

        if ($this->form_validation->run() === false) {
            $errors = array();
            foreach (array('old_password', 'password', 'new_password') as $name) {
                $single = $this->form_validation->error($name, ' ', ' ');
                if (empty($single) === false) {
                    array_push($errors, trim($single));
                }
            }
            return $this->jsonOutput(array('error' => 'All fields are mandatory', 'extended' => $errors), 400, 'Bad Data');
        }

        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
        if ($this->form_validation->run() === false) {
            return $this->jsonOutput(array('error' => 'Password has to be at least 6 characters long'), 400);
        }
        //matches[new_password]
        $this->form_validation->set_rules('password', 'Password', 'trim|matches[new_password]');
        if ($this->form_validation->run() === false) {
            return $this->jsonOutput(array('error' => 'We can\'t confirm new password you typed in Password field and Retyped'), 400);
        }

        $currentTeacher = $this->session->userdata('userdata');
        $userId = $currentTeacher->getId();

        $old_password = $this->input->post('old_password');
        $teacher = $this->teacher_model->get_user_by_id($userId);

        if ($teacher->getPassword() !== md5($old_password)) {
            return $this->jsonOutput(array('error' => 'We can\'t confirm your current password'), 400);
        }

        //looks like everything is fine
        $data = new stdClass();
        $data->password = md5($this->input->post('password'));

        $this->teacher_model->save($data, $userId);
        return $this->jsonOutput(array('success'=>true));

    }

    public function publisherProfilePut()
    {
        $data = new stdClass();
        $data->biography = $this->input->post('biography');

        $this->teacher_model->save($data, TeacherHelper::getUserId());
        return $this->jsonOutput(array('success'=>true));
    }

    public function avatarGet()
    {
        $content = null;

        $image = $this->teacher_model->get_teacher_image(TeacherHelper::getUserId());
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image['image_thumb']));
    }

    public function display_teacher_image()
    {
        return $this->avatarGet();
    }

    public function avatarPut()
    {
        $image = $this->pluploadlib_new->process_upload();
        $out = array(
            'url' => config_item('upload_url') . '/' . $image,
            'image_name' => $image
        );

        $data = new stdClass();

        $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR. trim($image);
        $fp = fopen($img_link,'r');

        $data->avatar = base64_encode(fread($fp,filesize($img_link)));
        $this->teacher_model->save($data, TeacherHelper::getUserId());

        fclose($fp);

        $this->output->set_output($image);
    }

    public function preventIntroVideo()
    {
        $teacher = PropTeacherQuery::create()->findOneByTeacherId(TeacherHelper::getId());
        $teacher->setViewIntro(PropTeacherPeer::VIEW_INTRO_TRUE);
        $teacher->save();
        return $this->jsonOutput(array('success'=>true));
    }

    protected function jsonOutput($data, $code = 200, $message = '')
    {
        return $this->output
            ->set_status_header($code, $message)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}