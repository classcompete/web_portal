<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 8/5/14
 * Time: 12:18 PM
 */

class Class_student_model extends CI_Model {

    public function __construct(){parent::__construct();}


    /**
     * Description : return list of classes which parent has bought fo student
     * @params studentId
     * @return array
    */
    public function getClassByBoughtLicence($studentId){
        $_classes = $this->db->select('name')
                            ->where('price >','0')
                            ->join('class_students','class_students.class_id = classes.class_id AND class_students.student_id = '.$studentId)
                            ->get('classes')->result_array();

        $classes = array();

        foreach($_classes as $class){
            $classes[] = $class['name'];
        }

        return $classes;
    }

} 