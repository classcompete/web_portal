<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/15/13
 * Time: 10:46 AM
 * To change this template use File | Settings | File Templates.
 */
class Challenge_classlib{
    private $ci;

    public function __construct(){

        $this->ci = &get_instance();
        $this->ci->load->model('x_challenge_class/challenge_class_model');
        $this->ci->load->helper('x_challenge_class/challenge_class');

    }

    public function safeToDelete($challengeId){
        $this->ci->challenge_class_model->filterByChallengeId($challengeId);
        $data = $this->ci->challenge_class_model->getList()->getFirst();
        if(empty($data)) return true;

        return false;
    }
}
class Challenge_classlib_Exception extends Exception
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