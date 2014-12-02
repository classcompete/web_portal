<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/17/13
 * Time: 11:51 AM
 * To change this template use File | Settings | File Templates.
 */
class Questionlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_question/question_model');
        $this->ci->load->helper('x_question/question');
    }

    public function isSafeToDelete($questionId){
        $scoreAnswers = PropScoreAnswerQuery::create()->findOneByQuestionId($questionId);

        if(empty($scoreAnswers)){
            return true;
        }

        return false;
    }

}
class Question_Exception extends Exception
{

    public function __construct($message, $code = null, $previous = null)
    {
        if ($code === null && $previous === null) {
            parent::__construct($message);
        } elseif ($previous === null && empty($code) === false) {
            parent::__construct($message, $code);
        } else {
            parent::__construct($message, $code, $previous);
        }

    }

}