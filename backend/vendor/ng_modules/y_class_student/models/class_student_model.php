<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 19:13
 */
class Class_student_model extends CI_Model{

    public function delete($class_id, $student_id){
        $class_student = PropClass_studentQuery::create()->filterByClassId($class_id)->filterByStudentId($student_id)->findOne();

        $class_student->setIsDeleted(PropClass_studentPeer::IS_DELETED_YES);

        $class_student->save();

        return $class_student;
    }

    public function getStudentCount(){

        $data = PropClass_studentQuery::create()
                    ->usePropClasQuery()
                        ->filterByTeacherId(TeacherHelper::getId())
                    ->endUse()
                 ->count();

        return $data;
    }

    public function get_students_in_class($class_id){
        return PropClass_studentQuery::create()->findByClassId($class_id);
    }

    public function getAmountStudentCount(){

        $data = PropClass_studentQuery::create()
            ->count();
        return $data;
    }
}