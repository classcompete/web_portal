<?php

class Studentlib
{

    private $ci;

    // *** DEFAULT USER ID, TO GET MISSING DATA WHEN ADDING NEW STUDENT FROM PARENT PORTAL
    private $defaultFemaleStudentId = 518;
    private $defaultMaleStudentId  = 517;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('x_users/student_model');
        $this->ci->load->model('x_users/student_import_model');
        $this->ci->load->helper('x_users/student');
    }

    public function encodePassword($pass)
    {
        $sql = "select password('" . $pass . "') as mySqlPass";

        $mysqlPass = $this->ci->db->query($sql)->row();
        return $mysqlPass->mySqlPass;
    }

    public function getDefaultFemaleStudentData()
    {
        return $this->ci->student_model->getStudentById($this->defaultFemaleStudentId);
    }

    public function getDefaultMaleStudentData()
    {
        return $this->ci->student_model->getStudentById($this->defaultMaleStudentId);
    }
}
