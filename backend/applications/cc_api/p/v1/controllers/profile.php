<?php
class Profile extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('y_user/parentlib');
        $this->load->library('p_timezone/timezonelib');
        $this->load->library('p_child/childlib');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
    }

    public function id_get($user_id)
    {
        $parent = $this->parent_model->get_parent_info($user_id);

        $data = new stdClass();

        $data->parent_info['user_id'] = $parent->getUserId();
        $data->parent_info['parent_id'] = $parent->getParentId();

        $data->parent_info['username'] = $parent->getPropUser()->getLogin();
        $data->parent_info['first_name'] = $parent->getPropUser()->getFirstName();
        $data->parent_info['last_name'] = $parent->getPropUser()->getLastName();
        $data->parent_info['email'] = $parent->getPropUser()->getEmail();
        $data->parent_info['image_thumb'] = $this->config->item('images_url') . 'parent_image/parent' . $parent->getUserId();

        $this->response($data);
    }

    public function index_get()
    {
        $parent = $this->parent_model->get_parent_info(ParentHelper::getUserId());

        $data = new stdClass();

        $data->parent_info['user_id'] = $parent->getUserId();
        $data->parent_info['parent_id'] = $parent->getParentId();

        $data->parent_info['username'] = $parent->getPropUser()->getLogin();
        $data->parent_info['first_name'] = $parent->getPropUser()->getFirstName();
        $data->parent_info['last_name'] = $parent->getPropUser()->getLastName();
        $data->parent_info['email'] = $parent->getPropUser()->getEmail();

        $data->parent_info['time_zone_diff'] = new stdClass();
        $data->parent_info['time_zone_diff']->id = null;
        $data->parent_info['time_zone_diff']->name = '';
        $data->parent_info['time_zone_diff']->difference = 0;

        $time_zones = $this->timezone_model->getList();
        foreach($time_zones as $time_zone){
            if($time_zone->getDifference() === $parent->getTimeDiff()){
                $data->parent_info['time_zone_diff']->id = $time_zone->getId();
                $data->parent_info['time_zone_diff']->name = $time_zone->getName();
                $data->parent_info['time_zone_diff']->difference = $time_zone->getDifference();
            }
        }

        $data->parent_info['image_thumb'] = $this->config->item('images_url') . 'parent_image/parent/' . $parent->getUserId();

        $this->response($data);
    }

    public function index_put()
    {
        $_POST = $this->put();

        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Lirst Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        $user_id = ParentHelper::getUserId();
        $out = new stdClass();
        $error = new stdClass();

        if ($this->form_validation->run() === false) {
            $error = REST_Form_validation::validation_errors_array();

            $this->response($error, 400);
        } else {
            $first_name = $this->put('first_name');
            $last_name = $this->put('last_name');
            $email = $this->put('email');
            $avatar = $this->put('parent_avatar_url');
            $time_zone_diff = $this->put('timezone_diff');

            $data = new stdClass();
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

                $img_link = X_PARENT_UPLOAD_PATH . DIRECTORY_SEPARATOR . trim($avatar);
                $fp = fopen($img_link, 'r');

                $data->avatar = base64_encode(fread($fp, filesize($img_link)));
                fclose($fp);
            }
            if(empty($time_zone_diff) === false){
                $data->time_diff = $time_zone_diff;
            }

            // password change
            $old_password = $this->put('old_password');
            $new_password = $this->put('new_password');
            $password2 = $this->put('re_new_password');

            if (!(empty($old_password) === true && empty($new_password) === true && empty($password2) === true)) {
                $this->form_validation->set_rules('old_password', 'Old Password', 'required|trim','callback_check_password_in_db');
                $this->form_validation->set_rules('new_password', 'Password', 'required|trim');
                $this->form_validation->set_rules('re_new_password', 'Password Confirmation', 'required|trim|matches[new_password]');

                if ($this->form_validation->run() === false) {
                    $error->data = REST_Form_validation::validation_errors_array();
                    $this->response($error, 400);

                } else {
                    $parent = $this->parent_model->get_user_by_id($user_id);

                    if($parent->getPassword() !== md5($old_password)){
                        $error->old_password = 'The Old Password field does not match the Password in our system.';
                        $this->response($error, 400);
                    }
                }
                $data->password = md5($new_password);

            }
        }
        $out->parent = $this->parent_model->save($data, $user_id);
        $this->response($out);
    }
}