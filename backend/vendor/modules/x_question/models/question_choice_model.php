<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/16/14
 * Time: 12:04 PM
 */
class Question_choice_model extends CI_Model{



    public function delete($questionId){
        return PropQuestionChoiceQuery::create()->filterByQuestionId($questionId)->delete();
    }

}