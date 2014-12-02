<?php



/**
 * Skeleton subclass for representing a row from the 'skills' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropSkills extends BasePropSkills {

    public function getSubjectName(){
        return self::getPropSubjects()->getName();
    }

} // PropSkills
