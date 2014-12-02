<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/11/13
 * Time: 7:09 PM
 * To change this template use File | Settings | File Templates.
 */
class Class_studentlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_class_student/class_student_model');
        $this->ci->load->helper('x_class_student/class_student');
    }
}
class ClassStudentlib_Exception extends Exception
{

    public function __construct($message, $code = null, $previous = null){
        if ($code === null && $previous === null) {
            parent::__construct($message);
        } elseif ($previous === null && empty($code) === false) {
            parent::__construct($message, $code);
        } else {
            parent::__construct($message, $code, $previous);
        }

    }
}

