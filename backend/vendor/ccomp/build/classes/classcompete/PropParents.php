<?php



/**
 * Skeleton subclass for representing a row from the 'parents' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropParents extends BasePropParents {

    public function getLogin(){
        return self::getPropUser()->getLogin();
    }
    public function getFirstName(){
        return self::getPropUser()->getFirstName();
    }
    public function getLastName(){
        return self::getPropUser()->getLastName();
    }
    public function getEmail(){
        return self::getPropUser()->getEmail();
    }
    public function getId(){
        return self::getUserId();
    }
    public function getUsername(){
        return self::getPropUser()->getLogin();
    }

    public function getCreated(){
        $db_time = parent::getCreated();
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff()*60*60));
        return $new_time;
    }

    public function getModified(){
        $db_time = parent::getModified();
        if($db_time === null) return $db_time;
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff()*60*60));
        return $new_time;
    }
} // PropParents
