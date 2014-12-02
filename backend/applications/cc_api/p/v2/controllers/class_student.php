<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 6/18/14
 * Time: 6:56 PM
 */
class Class_student extends REST_Controller {

    public function __construct(){
        parent::__construct();

        if(!ParentHelper::getId()){
            $this->response(null,401);
        }
    }

    public function index_post(){

        $respond = array();

        $classId = $this->post('class');
        $students = $this->post('students');
        $parentId = ParentHelper::getId();
        $class = PropClasQuery::create()->findOneByClassId($classId);

        // discover number of students selected already in class
        $totalClass = PropClass_studentQuery::create()->filterByClassId($classId)->filterByStudentId($students, Criteria::IN)->find()->count();
        // get number of available slots for user
        $activation = PropParentActivationQuery::create()->filterByClassId($classId)->filterByParentId($parentId)->findOne();

        if ($totalClass > $activation->getQuantity()) {
            $this->response('You have selected ' . $totalClass . ' student(s) to assign to this class<br/>You have only ' . $activation->getQuantity() . ' activation(s) available.',400);
        } else if ($class->getLimit() > 0 && $class->getAvailable() < count($students)) {
            $this->response('Only ' . $class->getAvailable() . ' slots available for this class.',400);
        } else if ($class->getLimit() > 0 && $class->getAvailable() <= 0) {
            $this->response('No more slots available for this classroom.',400);
        } else {
            $studentsAssigned = 0;
            foreach ($students as $studentId){

                $inClass = PropClass_studentQuery::create()->filterByClassId($classId)->filterByStudentId($studentId)->find()->count();
                if ($inClass < 1 && $activation->getQuantity() > 0) {
                    // add student to Class
                    $studentInClass = new PropClass_student();
                    $studentInClass->setClassId($classId);
                    $studentInClass->setStudentId($studentId);
                    $studentInClass->save();
                    // decrease number of activation on this one
                    $activation->setQuantity($activation->getQuantity() - 1);
                    $activation->save();
                    $studentsAssigned++;
                }
            }

            $respond = new stdClass();
            $respond->message = 'Successfully assigned ' . $studentsAssigned . ' student(s) to classroom ' . $class->getName();

            $this->response($respond, 200);
        }

    }

}