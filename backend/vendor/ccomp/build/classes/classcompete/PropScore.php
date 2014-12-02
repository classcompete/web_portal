<?php



/**
 * Skeleton subclass for representing a row from the 'scores' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropScore extends BasePropScore {


    /*
     * 0 - Answer correct
     * 1 - Answer wrong
     * 2 - Boost begin
     * 3 - Boost end
     */
    public function getCorrectAnswersCount(){
            $game_event_data = $this->getGameEventData();
            if(strpos($game_event_data,'|0;') != false){
                $correct_answers = substr_count($game_event_data , '|0;');
            }else if(strpos($game_event_data,'AnswerCorrect') != false){
                $correct_answers = substr_count($game_event_data , 'AnswerCorrect');
            }
            else{
                $correct_answers = 0;
            }

        return $correct_answers;
    }

    public function getWrongAnswersCount(){
        $game_event_data = $this->getGameEventData();
        if(strpos($game_event_data,'|1;') != false){
            $wrong_answers = substr_count($game_event_data , '|1;');
        }else if(strpos($game_event_data,'AnswerWrong') != false){
            $wrong_answers = substr_count($game_event_data, 'AnswerWrong');
        }
        else{
            $wrong_answers = 0;
        }

        return $wrong_answers;
    }

} // PropScore
