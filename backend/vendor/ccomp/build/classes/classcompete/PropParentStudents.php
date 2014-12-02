<?php



/**
 * Skeleton subclass for representing a row from the 'parent_students' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropParentStudents extends BasePropParentStudents
{
    public function getStudentUsername()
    {
        return self::getPropStudent()->getPropUser()->getLogin();
    }

    public function getParentUsername()
    {
        return self::getPropParent()->getPropUser()->getLogin();
    }
    public function getCreatedAt(){
        $db_time = parent::getCreatedAt();
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * $this->getTimezoneDiff()*60*60));
        return $new_time;
    }

    public function getUpdatedAt(){
        $db_time = parent::getUpdatedAt();
        if($db_time === null) return $db_time;
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * $this->getTimezoneDiff()*60*60));
        return $new_time;
    }

    private function getTimezoneDiff(){
        return -5;
    }
} // PropParentStudents
