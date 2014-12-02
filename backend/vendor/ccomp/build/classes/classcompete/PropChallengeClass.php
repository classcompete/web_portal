<?php



/**
 * Skeleton subclass for representing a row from the 'challenge_classes' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropChallengeClass extends BasePropChallengeClass {

    public function getId(){
        return self::getChallclassId();
    }
    public function getNameChallenge(){
        return self::getPropChallenge()->getName();
    }
    public function getNameClass(){
        return self::getPropClas()->getName();
    }
    public function getName(){
        return null;
    }
} // PropChallengeClass
