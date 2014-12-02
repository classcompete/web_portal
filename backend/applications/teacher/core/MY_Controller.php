<?php

class MY_Controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // is there autologin token
        $autologin_token = TeacherHelper::get_autologin_token();
        if (empty($autologin_token) !== true) {
            $admin = $this->teacherlib->set_teacher_autologin($autologin_token);
        }
        if (TeacherHelper::is_teacher() === false && $this->uri->segment(1) !== 'auth') {
            redirect('auth/login');
        }
    }

    public function prepareView($module, $view, $data = null)
    {
        $template_name = $this->config->item('teacher_template');
        $view_path = $module . '/' . $template_name . '/' . $view;
        return $this->load->view($view_path, $data, true);
    }
}
