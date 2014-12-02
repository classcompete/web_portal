<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/4/13
 * Time: 4:14 PM
 * To change this template use File | Settings | File Templates.
 */
class Gameslib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_games/games_model');
        $this->ci->load->helper('x_games/games');
    }
}
class Gemes_Exception extends Exception
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