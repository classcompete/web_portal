<?php



/**
 * Skeleton subclass for representing a row from the 'users' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropUser extends BasePropUser {
    //overwrite func getId to match GetUserId
    public function getId(){
        return self::getUserId();
    }

    public function getUsername(){
        return self::getLogin();
    }

    public function getPropStudent($criteria = null, PropelPDO $con = null)
    {
        return self::getPropStudents($criteria, $con)->getFirst();
    }

    public function getCreated(){
        $db_time = parent::getCreated();
        if($db_time === null) return $db_time;

        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff()*60*60));
        return $new_time;
    }

    public function getModified(){
        $db_time = parent::getModified();
        if($db_time === null) return $db_time;

        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff()*60*60));
        return $new_time;

    }
} // PropUser
