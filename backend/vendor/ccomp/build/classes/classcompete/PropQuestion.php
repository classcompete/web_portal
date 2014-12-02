<?php



/**
 * Skeleton subclass for representing a row from the 'questions' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropQuestion extends BasePropQuestion {


    public function getId(){
        return self::getQuestionId();
    }
    public function getSubjectName(){
        return self::getPropSubjects()->getName();
    }
    public function getSkillName(){
        return self::getPropSkills()->getName();
    }
    public function getUsername(){
        return null;
    }

} // PropQuestion
