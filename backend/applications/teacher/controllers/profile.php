<?php

class Profile extends MY_Controller
{

    public function __construct()
    {
        parent:: __construct();

        $this->load->model('x_users/teacher_model');
        $this->load->library('x_plupload/pluploadlib_new');
        $this->load->model('x_school/school_model');
        $this->load->library('x_timezone/timezonelib');
    }

    public function preventIntroVideo()
    {
        $teacher = PropTeacherQuery::create()->findOneByTeacherId(TeacherHelper::getId());
        $teacher->setViewIntro(PropTeacherPeer::VIEW_INTRO_TRUE);
        $teacher->save();
        echo 'done';
        exit();
    }

    public function index()
    {

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('profile/index/' . $uri);
        }

        $data = new stdClass();



        $data->teacher_info = $this->teacher_model->get_teacher_info(TeacherHelper::getUserId());
        $grades = $this->teacher_model->get_teacher_grades(TeacherHelper::getId());
        $data->teacher_grades = new stdClass();
        foreach($grades as $grade =>$val){
            switch($val->getGrade()){
                case -2:
                    $data->teacher_grades->grade_pre_k = true;
                    break;
                case -1:
                    $data->teacher_grades->grade_k = true;
                    break;
                case 1:
                    $data->teacher_grades->grade_1 = true;
                    break;
                case 2:
                    $data->teacher_grades->grade_2 = true;
                    break;
                case 3:
                    $data->teacher_grades->grade_3 = true;
                    break;
                case 4:
                    $data->teacher_grades->grade_4 = true;
                    break;
                case 5:
                    $data->teacher_grades->grade_5 = true;
                    break;
                case 6:
                    $data->teacher_grades->grade_6 = true;
                    break;
                case 7:
                    $data->teacher_grades->grade_7 = true;
                    break;
                case 8:
                    $data->teacher_grades->grade_8 = true;
                    break;
                case 9:
                    $data->teacher_grades->high_school = true;
                    break;
                case 10:
                    $data->teacher_grades->higher_ed = true;
                    break;
            }

        }

        $data->timezone = $this->timezone_model->getList();

        $countryList = PropCountryQuery::create()->filterByStatus(PropCountryPeer::STATUS_ACTIVE)->orderByName(Criteria::ASC)->find();
        $data->countryList = $countryList;

        $data->content = $this->prepareView('x_home_teacher', 'profile', $data);
        $this->load->view(config_item('teacher_template'), $data);
    }

    public function password_update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_password', 'Old Password', 'required|trim');
        $this->form_validation->set_rules('password1', 'Password', 'required|matches[password2]|trim');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'required|trim');

        $current_user = $this->session->userdata('userdata');
        $user_id = $current_user->getId();

        if ($this->form_validation->run() === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $user_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $old_password = $this->input->post('old_password');
            $teacher = $this->teacher_model->get_user_by_id($user_id);

            if ($teacher->getPassword() === md5($old_password)) {
                if ($this->input->post('password1') === $this->input->post('password2')) {
                    $data = new stdClass();
                    $data->password = md5($this->input->post('password1'));

                    $this->teacher_model->save($data, $user_id);

                    redirect('home');
                } else {
                    // error message: password1 and password2 are different
                }
            } else {
                // error message: your old password is not the same as one in the db
            }
        }
    }

    public function info_update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Lirst Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('bio', 'Biography','trim');

        $current_user = $this->session->userdata('userdata');
        $user_id = $current_user->getId();

        if ($this->form_validation->run() === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $user_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $first_name = $this->input->post('first_name');
            $last_name  = $this->input->post('last_name');
            $email      = $this->input->post('email');
            $avatar     = $this->input->post('teacher_avatar_url');
            $biography  = $this->input->post('bio');
            $grades     = $this->input->post('grade');
            $country    = $this->input->post('country');

            $data               = new stdClass();
            $data->grades       = new stdClass();
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

                $img_link = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR. trim($avatar);
                $fp = fopen($img_link,'r');

                $data->avatar = base64_encode(fread($fp,filesize($img_link)));
                fclose($fp);
            }
            if(empty($biography) === false){
                $data->biography = $biography;
            }
            if (empty($country) === false) {
                $data->country = $country;
            }

            if(isset($grades) === true && empty($grades) === false){
                foreach($grades as $grades=>$val){
                    $data->grades->$grades = $grades;
                }
            }

            $this->teacher_model->save($data, $user_id);

            redirect('profile');
        }
    }

    public function ajax_pass_validation()
    {
        $this->load->library('form_validation');

        $error = array();

        $this->form_validation->set_rules('old_password', 'Old Password', 'required|trim');
        $this->form_validation->set_rules('password1', 'Password', 'required|matches[password2]|trim');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'required|trim');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === false) {

            $old_password_error = form_error('old_password');
            $password1_error = form_error('password1');
            $password2_error = form_error('password2');

            if (empty($old_password_error) === false) {
                $error['old_password'] = form_error('old_password');
            } else {
                $current_user = $this->session->userdata('userdata');
                $user_id = $current_user->getId();

                $old_password = $this->input->post('old_password');
                $teacher = $this->teacher_model->get_user_by_id($user_id);

                if ($teacher->getPassword() !== md5($old_password)) {
                    $error['old_password'] = "Old password field does not match the system password";
                }
            }

            if (empty($password1_error) === false) {
                $error['password1'] = form_error('password1');
            }
            if (empty($password2_error) === false) {
                $error['password2'] = form_error('password2');
            }

            $this->output->set_status_header('400');
        } else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));
    }

    public function ajax_info_validation()
    {
        $this->load->library('form_validation');

        $error = array();

        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Lirst Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === false) {

            $first_name_error = form_error('first_name');
            $last_name_error = form_error('last_name');
            $email_error = form_error('email');

            if (empty($first_name_error) === false) {
                $error['first_name'] = form_error('first_name');
            }
            if (empty($last_name_error) === false) {
                $error['last_name'] = form_error('last_name');
            }
            if (empty($email_error) === false) {
                $error['email'] = form_error('email');
            }

            $this->output->set_status_header('400');
        } else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));
    }

    /*
     * function for uploading teacher image
     * */

    public function update_image()
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

    public function school_update(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('zip_code', 'Zip code', 'required|trim');
        $this->form_validation->set_rules('school_name', 'School name', 'required|trim');


        $listed_school      = $this->input->post('not_listed');
        $data = new stdClass();
        $error = array();
        if($this->form_validation->run() === false){
            redirect('/profile');
        }
        if(isset($listed_school) === true && empty($listed_school) === false){
            $data->zip_code = $this->input->post('zip_code');
            $data->school_name = $this->input->post('school_name');
        }else{
            $data->school_id    = $this->input->post('school_id');
        }

        $teacher = $this->teacher_model->change_school($data);

        redirect('/profile');
    }

    public function ajax_validate_school(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('zip_code', 'Zip code', 'required|trim');
        $this->form_validation->set_rules('school_name', 'School name', 'required|trim');


        $school_id = $this->input->post('school_id');
        $listed_school      = $this->input->post('not_listed');


        if(empty($school_id) === true){

            $this->form_validation->set_rules('not_listed', 'not_listed', 'required|trim');
        }

        $error = array();
        if($this->form_validation->run() === false){
            if(form_error('zip_code') != '')
                $error['zip_code'] = form_error('zip_code');
            if(form_error('school_name') != '')
                $error['school_name'] = form_error('school_name');
            if(form_error('not_listed') != '')
                $error['not_listed'] = 'My school is not listes is required field';

            $this->output->set_status_header('200');
        }else{

            $error['validation'] = true;
        }

        $this->output->set_output(json_encode($error));
    }

    /*
    * function to display teacher image
    * @params: $user_id
    * @output: image
    * */
    public function display_teacher_image()
    {
        $content = null;

        $image = $this->teacher_model->get_teacher_image(TeacherHelper::getUserId());
        $this->output->set_header('Content-type: image/png');
        $this->output->set_output(base64_decode($image['image_thumb']));
    }

    public function ajax_school(){
        $school = $this->input->post('school');

        $query = $this->school_model->find_school($school['school'], $school['zip_code']);


        $this->output->set_output(json_encode($query));

    }

    public function process_change_timezone(){
        $time_zone_diff = $this->input->post('timezone');

        if(isset($time_zone_diff) === true && empty($time_zone_diff) === false){
            $data = new stdClass();
            $data->time_diff = $time_zone_diff;
            $this->teacher_model->save($data,TeacherHelper::getUserId());
        }

        redirect('profile');
    }
}