<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 6/16/14
 * Time: 3:05 PM
 */
class Free_student extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('x_user/studentlib');
        $this->load->library('x_user/userlib');
        $this->load->library('form_validation');


        if(!ParentHelper::isParent()){
            $this->response(null,401);
        }
    }

    public function index_get(){

        $respond = array();

        $classID = $this->get('classId');
        $this->parent_student_model->filterByParentId(ParentHelper::getId());
        $students = $this->parent_student_model->getStudentsWithoutClass($classID);
        $studentsLength = sizeof($students);

        for($i = 0; $i < $studentsLength; $i++){
            $tmpStudent = $students[$i];

            $studentId = $tmpStudent['student_id'];

            $inClass = PropClass_studentQuery::create()->filterByClassId($classID)->filterByStudentId($studentId)->find()->count();

            if ($inClass === 0) {
                $single = array();
                $single['studentId'] = $studentId;
                $single['firstName'] = $tmpStudent['first_name'];
                $single['lastName'] = $tmpStudent['last_name'];

                $respond[] = $single;
            }
        }

        $this->response($respond, 200);
    }

}
