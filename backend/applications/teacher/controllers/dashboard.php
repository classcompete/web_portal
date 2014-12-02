<?php

class Dashboard extends MY_Controller
{
    public function index()
    {
        $data = new stdClass();
        $data->content = $this->load->view('dashboard', $data, true);

        $this->load->view(config_item('teacher_template'), $data);
    }
}