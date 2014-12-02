<?php



/**
 * Skeleton subclass for representing a row from the 'challenges' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropChallenge extends BasePropChallenge {

    public function getId(){
        return self::getChallengeId();
    }
    public function getNameChallenge(){
        return self::getName();
    }
    public function getNameSubject(){
        return self::getPropSubjects()->getName();
    }
    public function getNameSkill(){
        return self::getPropSkills()->getName();
    }
    public function getNameGame(){
        return self::getPropGames()->getName();
    }
    public function getNameGameLevel(){
        return self::getPropGameLevels()->getName();
    }
    public function getNameTopic(){
        return self::getPropTopic()->getName();
    }
    public function getCountQuestion(){
        return self::getPropChallengeQuestions()->count();
    }
} // PropChallenge
