<?php

class General extends MY_Controller
{
    public function index()
    {
        $data = new stdClass();

        $data->content = $this->prepareView('x_admin', 'general', $data);

        $this->load->view(config_item('admin_template'), $data);
    }
}