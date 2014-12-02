<?php



/**
 * Skeleton subclass for representing a row from the 'students' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropStudent extends BasePropStudent {
    public function getAvatarThumb() {
        return $this->getAvatarThumbnail();
    }
    public function getStudentFirstName(){
        return self::getPropUser()->getFirstName();
    }
    public function getStudentLastName(){
        return self::getPropUser()->getLastName();
    }

    public function getUpdatedAt(){
        $db_time = parent::getCreated();
        if($db_time === null) return $db_time;
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff()*60*60));
        return $new_time;
    }

    public function getLastLoginTime(){
        $db_time = parent::getModified();
        if($db_time === null) return $db_time;
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff()*60*60));
        return $new_time;
    }
} // PropStudent
