<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/4/14
 * Time: 12:24 PM
 */
class Studentlib{
    private $ci;

    // *** DEFAULT USER ID, TO GET MISSING DATA WHEN ADDING NEW STUDENT FROM PARENT PORTAL
    private $defaultFemaleStudentId = 518;
    private $defaultMaleStudentId  = 517;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->helper('x_user/student');
        $this->ci->load->model('x_user/student_model');
    }

    public function createMysqlPassword($pass){
        $sql = "select password('".$pass."') as mySqlPass";

        $mysqlPass = $this->ci->db->query($sql)->row();
        return $mysqlPass->mySqlPass;
    }

    public function getDefaultFemaleStudentData (){
        return $this->ci->student_model->getStudent($this->defaultFemaleStudentId);
    }
    public function getDefaultMaleStudentData(){
        return $this->ci->student_model->getStudent($this->defaultMaleStudentId);
    }

    public function getNextStudentId(){
        $result = $this->ci->db->select('student_id')->order_by('student_id','desc')->limit(1)->get('students')->result_array();
        return intval($result[0]['student_id']) + 1;
    }

}