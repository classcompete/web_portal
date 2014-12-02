<?php



/**
 * Skeleton subclass for representing a row from the 'topics' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropTopic extends BasePropTopic {

    public function getSkillName(){
        return self::getPropSkills()->getName();
    }
    public function getSubjectName(){
        return self:: getPropSkills()->getPropSubjects()->getName();
    }
    public function getNameTopic(){
        return self::getName();
    }

} // PropTopic
