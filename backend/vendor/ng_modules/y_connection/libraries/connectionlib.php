<?php

class Connectionlib
{
    private $ci;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->model('y_connection/connection_model');
        $this->ci->load->helper('y_connection/connection');
    }

    public function check_if_student_connected_with_some_parent($student_id)
    {
        $connection = $this->ci->connection_model->get_connection_by_student_id($student_id);

        if (empty($connection) === false) {
            $out = true;
        } else {
            $out = false;
        }

        return $out;
    }
}