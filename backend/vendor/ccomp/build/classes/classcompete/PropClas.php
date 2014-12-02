<?php


/**
 * Skeleton subclass for representing a row from the 'classes' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropClas extends BasePropClas
{

    public function getId()
    {
        return self::getClassId();
    }

    public function getClassName()
    {
        return self::getName();
    }

    public function getTeacherLogin()
    {
        return self::getPropTeacher()->getPropUser()->getLogin();
    }

    public function getTeacherLastName()
    {
        return self::getPropTeacher()->getPropUser()->getLastName();
    }

    public function getTeacherFirstName()
    {
        return self::getPropTeacher()->getPropUser()->getFirstName();
    }

    public function getAvailable()
    {
        $classLimit = self::getLimit();
        if ($classLimit > 0) {
            // we have limit defined - lets do some math
            $inClass = PropClass_studentQuery::create()->filterByClassId(self::getId())->count();
            $classLimit = $classLimit - $inClass;
        }

        return $classLimit;
    }
} // PropClas
