<?php

class MY_Controller extends MX_Controller
{
    public function __construct() {
        parent::__construct();
            //Is there autologin token
        $autologin_token = TeacherHelper::get_autologin_token();
        if (empty($autologin_token) !== true) {
            $teacherUser = $this->teacherlib->set_teacher_autologin($autologin_token);
        }

	        //If teacher is not logged - goto login
	    if (! TeacherHelper::is_teacher()) {
	        if ($this->uri->segment(1) !== 'auth' &&
	            $this->uri->segment(2) !== 'auth' &&
	            $this->uri->segment(3) !== 'auth') {
	            redirect('auth/login');
	        }
	    }
	    else {
		        //If teacher is logged - log his request for page as his last action on site
			$teacherUser = $this->teacherlib->get_teacher_user_from_session();
		    if ($teacherUser) {
			    $doLog = TRUE;
			    $actionStr = $this->uri->uri_string();
			    $segArr = $this->uri->segment_array();

			    if (! $actionStr) { $actionStr = 'home'; }
			    else if (stripos($actionStr, 'ajax') !== FALSE) { $doLog = FALSE; }
			    else if (stripos($actionStr, 'display_teacher_image') !== FALSE) { $doLog = FALSE; }
			    else if (stripos($actionStr, 'process_logout') !== FALSE) { $doLog = FALSE; }
			    //else if (array_search('display_teacher_image', $segArr) !== FALSE) { $doLog = FALSE; }

			    if ($doLog) { $this->userslib->logUserActivity($teacherUser, $actionStr); }
		    }
	    }
    }

    public function prepareView($module, $view, $data = null)
    {
        $template_name = $this->config->item('teacher_template');
        $view_path = $module . '/' . $template_name . '/' . $view;
        return $this->load->view($view_path, $data, true);
    }
}
