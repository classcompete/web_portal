<?php

class Tinymce extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        $this->load->view('x_tinymce/init');
    }
}