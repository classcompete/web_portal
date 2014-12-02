<?php


/**
 * Skeleton subclass for representing a row from the 'challenge_questions' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropChallengeQuestion extends BasePropChallengeQuestion {

    public function getSubjectName(){
        return self:: getPropQuestion()->getPropSubjects()->getName();
    }
    public function getSkillName(){
        return self:: getPropQuestion()->getPropSkills()->getName();
    }
    public function getLevel(){
        return self:: getPropQuestion()->getLevel();
    }
    public function getType(){
        return self:: getPropQuestion()->getType();
    }
    public function getText(){
        return self:: getPropQuestion()->getText();
    }
    public function getCorrectChoiceId(){
        return self::getPropQuestion()->getCorrectChoiceId();
    }
    public function getCorrectText(){
        return self:: getPropQuestion()->getCorrectText();
    }
    public function getId(){
        return self::getCorrectChoiceId();
    }
    public function getUsername(){
        return null;
    }
} // PropChallengeQuestion
