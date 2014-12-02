<?php



/**
 * Skeleton subclass for representing a row from the 'teachers' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropTeacher extends BasePropTeacher {

    public function getCreatedAt(){
        $db_time = parent::getCreated();
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff()*60*60));
        return $new_time;
    }

    public function getUpdatedAt(){
        $db_time = parent::getModified();
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff()*60*60));
        return $new_time;
    }


} // PropTeacher
