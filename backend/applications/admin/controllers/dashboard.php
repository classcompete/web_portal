<?php

class Dashboard extends MY_Controller
{
    public function index()
    {
	    $this->load->model('x_users/teacher_model');
	    $this->load->model('x_users/user_activity_model');
	    //15
	    //60
	    //24 * 60
	    //7 * 24 * 60
	    //30 * 24 * 60
	    $teacherOnlineData = array();

	        //Get total number of teachers
	    $this->teacher_model->getList();
	    $totalTeachers = $this->teacher_model->getFoundRows();

	        //Get online teachers in last 15 min
	    $this->user_activity_model->resetFilters();
	    $this->user_activity_model->filterTeachers(TRUE);
	    $this->user_activity_model->filterByUpdatedAt(15);
	    $this->user_activity_model->getList();
	    $totalTeachersOnline = $this->user_activity_model->getFoundRows();

	    $teacherOnlineData['15min'] = array(
		    'total' => $totalTeachersOnline,
	        'percent' => round(($totalTeachersOnline * 100) / $totalTeachers, 2)
	    );

	        //Get online teachers in last hour
	    $this->user_activity_model->resetFilters();
	    $this->user_activity_model->filterTeachers(TRUE);
	    $this->user_activity_model->filterByUpdatedAt(60);
	    $this->user_activity_model->getList();
	    $totalTeachersOnline = $this->user_activity_model->getFoundRows();

	    $teacherOnlineData['hour'] = array(
		    'total' => $totalTeachersOnline,
	        'percent' => round(($totalTeachersOnline * 100) / $totalTeachers, 2)
	    );

	        //Get online teachers in last day
	    $this->user_activity_model->resetFilters();
	    $this->user_activity_model->filterTeachers(TRUE);
	    $this->user_activity_model->filterByUpdatedAt(24 * 60);
	    $this->user_activity_model->getList();
	    $totalTeachersOnline = $this->user_activity_model->getFoundRows();

	    $teacherOnlineData['day'] = array(
		    'total' => $totalTeachersOnline,
	        'percent' => round(($totalTeachersOnline * 100) / $totalTeachers, 2)
	    );

	        //Get online teachers in last week
	    $this->user_activity_model->resetFilters();
	    $this->user_activity_model->filterTeachers(TRUE);
	    $this->user_activity_model->filterByUpdatedAt(7 * 24 * 60);
	    $this->user_activity_model->getList();
	    $totalTeachersOnline = $this->user_activity_model->getFoundRows();

	    $teacherOnlineData['week'] = array(
		    'total' => $totalTeachersOnline,
	        'percent' => round(($totalTeachersOnline * 100) / $totalTeachers, 2)
	    );

	        //Get online teachers in last month
	    $this->user_activity_model->resetFilters();
	    $this->user_activity_model->filterTeachers(TRUE);
	    $this->user_activity_model->filterByUpdatedAt(30 * 24 * 60);
	    $this->user_activity_model->getList();
	    $totalTeachersOnline = $this->user_activity_model->getFoundRows();

	    $teacherOnlineData['month'] = array(
		    'total' => $totalTeachersOnline,
	        'percent' => round(($totalTeachersOnline * 100) / $totalTeachers, 2)
	    );

        $data = new stdClass();
	    $data->teacherOnlineData = $teacherOnlineData;
        $data->content = $this->load->view('dashboard', $data, true);

        $this->load->view(config_item('admin_template'), $data);
    }
}