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
class PropUsers extends BasePropUsers {

    //overwrite func getId to match GetUserId
    public function getId(){
        return self::getUserId();
    }

    public function getUsername(){
        return self::getLogin();
    }

    public function getPropStudent()
    {
        $student = PropStudentQuery::create()->findOneByUserId(self::getUserId());
        if (empty($student) === true) {
            $student = null;
        }

        return $student;
    }

} // PropUsers
