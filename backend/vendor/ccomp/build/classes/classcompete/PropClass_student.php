<?php



/**
 * Skeleton subclass for representing a row from the 'class_students' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropClass_student extends BasePropClass_student {
    public function getId(){
        return self::getClassstudId();
    }
    public function getName(){
        return self::getPropClas()->getName();
    }
    public function getStudentFirstName(){
        return self::getPropStudent()->getPropUser()->getFirstName();
    }
    public function orderByStudentFirstName(){
        return self::usePropStudentQuery()->usePropUsersQuesry()->orderByFirstName()->endUse()->endUse();
    }
    public function orderByClassName(){

        return self::usePropClasQuery()->orderByName()->endUse();
    }
    public function getStudentLastName(){
        return self::getPropStudent()->getPropUser()->getLastName();
    }
    public function getClassName(){
        return self::getPropClas()->getName();
    }
    public function getUserId(){
        return self::getPropStudent()->getPropUser()->getUserId();
    }
    public function getFirstName(){
        return self:: getPropStudent()->getPropUser()->getFirstName();
    }
    public function getLastName(){
        return self:: getPropStudent()->getPropUser()->getLastName();
    }
    public function getUsername(){
        return self::getPropStudent()->getPropUser()->getLogin();
    }
} // PropClass_student
